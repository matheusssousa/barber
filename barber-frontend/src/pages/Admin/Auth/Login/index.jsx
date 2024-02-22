import React, { useState } from "react";
import { useAuth } from "../../../../providers/AuthProvider";
import Logo from "../../../../assets/svg/Logo.svg";
import './style.css';

export default function PageLoginAdmin() {
    const { LoginAdmin } = useAuth();

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');

    const EnviarDadosLogin = async (event) => {
        event.preventDefault();
        try {
            await LoginAdmin({
                email: email,
                password: password,
            });
        } catch (error) {
            setPassword('');
        }
    };

    return (
        <div className="page-body-preto flex justify-center items-center">
            <form className="content-login-admin" onSubmit={EnviarDadosLogin}>
                <img src={Logo} alt="Logo" />
                <p className="title">Acesso Administrador</p>
                <div className="input-group">
                    <label htmlFor="email">Email</label>
                    <input type="email" name="email" id="email" value={email} onChange={(event) => setEmail(event.target.value)} required />
                </div>
                <div className="input-group">
                    <label htmlFor="password">Senha</label>
                    <input type="password" name="password" id="password" value={password} onChange={(event) => setPassword(event.target.value)} required />
                </div>
                <a href="#" className="esqueceu-a-senha">Esqueceu a senha?</a>
                <button type="submit">Entrar</button>
            </form>
        </div>
    )
}