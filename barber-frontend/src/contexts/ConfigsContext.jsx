import React, { createContext, useEffect, useState } from "react";
import { useContext } from "react";
import ApiUser from "../services/apiUser";
import ApiAdmin from "../services/apiAdmin";

const ConfigsContext = createContext();

export const ConfigsProvider = ({ children }) => {
    const [configs, setConfigs] = useState(null);

    async function ConfigsRequest() {
        await ApiUser.get('/contexto').then(function (response) {
            setConfigs(response.data);
        }).catch(function (error) {
            console.log(error);
        });
    };

    async function AddConfigsRequest(data) {
        await ApiAdmin.post(`/contexto/${data.id}`, {data}).then(function (response) {
            console.log(response);
        }).catch(function (error) {
            console.log(error);
        });
    }

    useEffect(() => {
        ConfigsRequest();
    }, [])

    return (
        <ConfigsContext.Provider value={{ configs, setConfigs, AddConfigsRequest }}>
            {children}
        </ConfigsContext.Provider>
    );
};

export const useConfigs = () => {
    return useContext(ConfigsContext);
};