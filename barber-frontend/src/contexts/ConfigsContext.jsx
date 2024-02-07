import React, { createContext, useState } from "react";
import { useContext } from "react";

const ConfigsContext = createContext();

export const ConfigsProvider = ({ children }) => {
    const [configs, setConfigs] = useState(null);

    return (
        <ConfigsContext.Provider value={{ configs, setConfigs }}>
            {children}
        </ConfigsContext.Provider>
    );
};

export const useConfigs = () => {
    return useContext(ConfigsContext);
};