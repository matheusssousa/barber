import React, { useState } from "react";
import Logo from "../../../../assets/svg/Logo.svg";
import { useAuth } from "../../../../providers/AuthProvider";

import './style.css';

export default function PageLoginUser(params) {
    const [phone, setPhone] = useState(undefined);
    const { Login } = useAuth();

    const EnviarDadosLogin = () => {
        const DadosLogin = [phone];
        Login(DadosLogin);
    }

    return (
        <div className="page-body-preto flex justify-center items-center">
            <div className="content-login">
                <img src={Logo} alt="Logo" />
                <form onSubmit={EnviarDadosLogin} className="form-login">
                    <div className="input-group">
                        <label htmlFor="phone">Telefone</label>
                        <input type="text" name="phone" id="phone" value={phone} onChange={(event) => setPhone(event.target.value)} required />
                    </div>
                    <button type="submit">Entrar</button>
                </form>
            </div>
        </div>
    )
}