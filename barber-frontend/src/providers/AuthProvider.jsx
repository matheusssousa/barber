import React, { createContext, useContext, useEffect, useState } from "react";

import ApiAdmin from "../services/apiAdmin";
import ApiUser from "../services/apiUser";

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const [authenticate, setAuthenticate] = useState(() => {
        const token = sessionStorage.getItem('@App:token');
        return token ? true : false;
    });
    const [admin, setAdmin] = useState(() => {
        const storedAdmin = sessionStorage.getItem('@App:admin');
        return storedAdmin ? JSON.parse(storedAdmin) : null;
    });
    const [user, setUser] = useState(() => {
        const storedUser = sessionStorage.getItem('@App:user');
        return storedUser ? JSON.parse(storedUser) : null;
    });

    // USUÁRIO NORMAL
    async function LoginUser(dataLogin) {
        try {
            const response = await ApiUser.post('/auth/login', { dataLogin });
            const { access_token, user } = response.data;
            sessionStorage.setItem('@App:token', access_token);
            sessionStorage.setItem('@App:user', JSON.stringify(user));
            setAuthenticate(true);
            setUser(user);
        } catch (error) {
            console.error(error);
        }
    }

    async function LogoutUser() {
        try {
            await ApiUser.post('/auth/logout');
            sessionStorage.removeItem('@App:token');
            sessionStorage.removeItem('@App:user');
            setAuthenticate(false);
            setUser(null);
        } catch (error) {
            console.error(error);
        }
    }


    async function RefreshTokenUser() {
        if (authenticate) {
            await ApiUser.post('/auth/refresh').then(function (response) {
                ApiUser.defaults.headers.Authorization = `Bearer ${response.data.access_token}`;
                sessionStorage.setItem('@App:token', response.data.access_token);
            }).catch(function (error) {
                setAuthenticate(false)
                setUser(null);
            })
        } else {
            return setUser(null);
        }
    }

    // USUÁRIO ADMINISTRADOR
    async function LoginAdmin(dataLogin) {
        try {
            const response = await ApiAdmin.post('/auth/login', dataLogin);
            const { access_token, user } = response.data;
            sessionStorage.setItem('@App:token', access_token);
            sessionStorage.setItem('@App:admin', JSON.stringify(user));
            setAuthenticate(true);
            setAdmin(user);
        } catch (error) {
            console.error(error);
        }
    }
    
    async function LogoutAdmin() {
        try {
            await ApiAdmin.post('/auth/logout');
            sessionStorage.removeItem('@App:token');
            sessionStorage.removeItem('@App:admin');
            setAuthenticate(false);
            setAdmin(null);
        } catch (error) {
            console.error(error);
        }
    }

    async function RefreshTokenAdmin() {
        if (authenticate) {
            await ApiAdmin.post('/auth/refresh').then(function (response) {
                ApiAdmin.defaults.headers.Authorization = `Bearer ${response.data.access_token}`;
                sessionStorage.setItem('@App:token', response.data.access_token);
            }).catch(function (error) {
                ApiAdmin.defaults.headers.Authorization = null;
                sessionStorage.removeItem('@App:token');
                setAuthenticate(false)
                setAdmin(null);
            })
        } else {
            return setAdmin(null);
        }
    }

    // RENOVAR TOKEN
    useEffect(() => {
        const interval = setInterval(() => {
            if (admin) {
                RefreshTokenAdmin();
            } else if (user) {
                RefreshTokenUser();
            }
        }, 3000000);
        return () => clearInterval(interval);
    }, []);

    return (
        <AuthContext.Provider value={{ authenticate, admin, user, LoginUser, LogoutUser, LoginAdmin, LogoutAdmin }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => {
    return useContext(AuthContext);
};