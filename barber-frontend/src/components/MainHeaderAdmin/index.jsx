import React from "react";
import Logo from '../../assets/svg/Logo.svg';
import { TextAlignLeft } from '@phosphor-icons/react';
import { useAuth } from '../../providers/AuthProvider';
import './style.css';

export default function MainHeaderAdmin() {
    const { admin } = useAuth();
    return (
        <>
            <div className="navbar-admin">
                <button type="button"><TextAlignLeft size={32} /></button>
                <p>ADMINISTRATIVO / <strong className="text-barber_marrom uppercase"></strong></p>
                <span></span>
            </div>
            {/* <nav className="sidebar-admin">
                <img src={Logo} alt="Logo" />
            </nav> */}
        </>
    )
}