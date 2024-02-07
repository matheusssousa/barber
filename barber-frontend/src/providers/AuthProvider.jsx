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
        await ApiUser.post('/auth/refresh').then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error)
        })
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
        await ApiAdmin.post('/auth/refresh').then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error)
        })
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
        <AuthContext.Provider value={{ authenticate, admin, user }}>
            {children}
        </AuthContext.Provider>
    );
};

export const useAuth = () => {
    return useContext(AuthContext);
};