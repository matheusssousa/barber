import React, { createContext, useContext, useEffect, useState } from "react";

import ApiAdmin from "../services/apiAdmin";
import ApiUser from "../services/apiUser";

const AuthContext = createContext();

export const AuthProvider = ({ children }) => {
    const [authenticate, setAuthenticate] = useState(false);
    const [admin, setAdmin] = useState(null);
    const [user, setUser] = useState(null);

    // USUÁRIO NORMAL
    async function LoginUser(dataLogin) {
        await ApiUser.post('/auth/login', { dataLogin }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    };

    async function LogoutUser() {
        await ApiUser.post('/auth/logout').then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    };

    async function RefreshTokenUser() {
        if (authenticate) {
            await ApiUser.post('/auth/refresh').then(function (response) {
                ApiUser.defaults.headers.Authorization = `Bearer ${response.data.acess_token}`;
                sessionStorage.setItem('@App:token', response.data.acess_token);
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
        await ApiAdmin.post('/auth/login', { dataLogin }).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    };

    async function LogoutAdmin() {
        await ApiAdmin.post('/auth/logout').then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    };

    async function RefreshTokenAdmin() {
        if (authenticate) {
            await ApiAdmin.post('/auth/refresh').then(function (response) {
                ApiAdmin.defaults.headers.Authorization = `Bearer ${response.data.acess_token}`;
                sessionStorage.setItem('@App:token', response.data.acess_token);
            }).catch(function (error) {
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