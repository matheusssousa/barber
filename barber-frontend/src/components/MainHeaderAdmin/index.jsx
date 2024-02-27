import React, { useState } from "react";
import Logo from '../../assets/svg/Logo.svg';
import { Calendar, CheckSquareOffset, ClockCounterClockwise, Command, Gear, House, MoonStars, Package, Scissors, UserCircle, Users, SunHorizon, List } from "@phosphor-icons/react";
import { useAuth } from '../../providers/AuthProvider';
import { useTheme } from '../../contexts/ThemeContext';
import { motion } from 'framer-motion';
import './style.css';
import { Link, NavLink } from "react-router-dom";

export default function MainHeaderAdmin() {
    const { admin, LogoutAdmin } = useAuth();
    const { theme, setTheme } = useTheme();

    const [openSubMenu, setOpenSubMenu] = useState(false);
    const [openSidebar, setOpenSidebar] = useState(true);

    // OBTER NOME PARA SUB-MENU USUÁRIO
    const firstName = admin.name.split(' ')[0];
    const lastName = admin.name.split(' ')[1];
    const letters = `${firstName.charAt(0)}${lastName ? lastName.charAt(0) : ''}`;

    // MAPA DE PÁGINAS DO ADMINISTRADOR
    const links = [
        { name: 'Início', link: '/admin/home', icon: House },
        { name: 'Relatórios', link: 'admin/relatorios', icon: Command },
        { name: 'Agendamentos', link: 'admin/relatorios', icon: Calendar },
        { name: 'Serviços', link: 'admin/relatorios', icon: CheckSquareOffset },
        { name: 'Cortes', link: 'admin/relatorios', icon: Scissors },
        { name: 'Pacotes', link: 'admin/relatorios', icon: Package },
        { name: 'Configurações', link: 'admin/relatorios', icon: Gear },
        { name: 'Usuários', link: 'admin/relatorios', icon: Users },
        { name: 'Administradores', link: 'admin/relatorios', icon: UserCircle },
        { name: 'Logs', link: 'admin/relatorios', icon: ClockCounterClockwise },
    ];

    // Função para deslogar
    const Logout = async (event) => {
        event.preventDefault();
        try {
            await LogoutAdmin();
        } catch (error) {
            console.log(error);
        }
    }

    return (
        <>
            <div className="navbar-admin">
                <div className="conjunt-logo-button">
                    <button type="button" className="btn-menu" onClick={() => setOpenSidebar(!openSidebar)}><List size={23} /></button>
                    <img src={Logo} alt="Logo" />
                </div>
                <p>ADMINISTRATIVO / <strong className="text-barber_marrom uppercase"></strong></p>
                <button type="button" onClick={() => setOpenSubMenu(!openSubMenu)} className="user">{letters}</button>
            </div>
            {openSubMenu &&
                <motion.div
                    initial={{ opacity: 0, scale: 0.9 }}
                    animate={{ opacity: 1, scale: 1 }}
                    exit={{ opacity: 0, scale: 0.9 }}
                    className="submenu-navbar-admin">
                    {theme === 'light' ? <button onClick={() => setTheme('dark')} className="button-mode-dark"><MoonStars size={20} />Modo Escuro</button> : <button onClick={() => setTheme('light')} className="button-mode-light"><SunHorizon size={20} />Modo Claro</button>}
                    <div className="bar-submenu-navbar-admin" />
                    <Link to='/admin/conta' className="w-full text-center">Conta</Link>
                    <button onClick={(e) => Logout(e)}>Sair</button>
                </motion.div>
            }
            <nav className={`${openSidebar ? 'open' : 'close'} sidebar-admin`}>
                {/* {links.map((link, i) => (
                    <>
                        {i == 3 && <hr/> || i == 6 && <hr/>}
                        <NavLink
                            key={i}
                            to={link.link}
                            className={({ isActive, isPending }) =>
                                isPending ? "link-pending group" : isActive ? "link-active group" : "link-pending group"
                            }>
                            <div className="link-icon">{React.createElement(link?.icon, { size: "23" })}<div className="link-bar"></div></div>
                            <span className='link-text'>
                                {link.name}
                            </span>
                        </NavLink>
                    </>
                ))} */}
            </nav>
        </>
    )
}