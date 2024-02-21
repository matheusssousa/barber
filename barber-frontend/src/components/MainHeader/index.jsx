import React from "react";

import { NavLink } from "react-router-dom";
import { Crown } from "@phosphor-icons/react";
import { useAuth } from "../../providers/AuthProvider";
import Logo from "../../assets/svg/Logo.svg";

import "./style.css";

export default function MainHeader() {
    const { user, authenticate } = useAuth();

    const links = [
        { name: 'Home', link: '/' },
        { name: 'Serviços e Preços', link: '/servicos' },
        { name: 'Contato', link: '/contato' },
        { name: 'Shop', link: '/shop' },
    ];

    return (
        <div className="main-header">
            <img src={Logo} alt="Logo" />
            <div className="content-links">
                {links.map((link, i) => (
                    <NavLink
                        key={i}
                        to={link.link}
                        className={({ isActive, isPending }) =>
                            isPending ? "link-pending" : isActive ? "link-active" : "link-pending"
                        }>
                        {link.name}
                    </NavLink>
                ))}
            </div>
            {user && authenticate ?
                <div>
                    {user.name}
                </div>
                :
                <a href="/login" className="button-login-user">
                    <Crown size={22} />
                    Entrar
                </a>
            }
        </div>
    )
}