import React from "react";
import { Navigate, Route, Routes } from "react-router-dom";

import HomeAdmin from '../../pages/Admin/Home';
import AgendamentoPageAdmin from '../../pages/Admin/Agendamentos';

export default function PrivateRoutesAdmin(params) {
    return (
        <Routes>
            <Route path="*" element={<Navigate to='/admin/home' />} />
            <Route path="/admin/home" element={<HomeAdmin />} />
            <Route path="/admin/agendamentos" element={<AgendamentoPageAdmin />} />
        </Routes>
    )
}