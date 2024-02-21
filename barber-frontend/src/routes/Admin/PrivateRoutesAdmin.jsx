import React from "react";
import { Route, Routes } from "react-router-dom";

import AgendamentoPageAdmin from '../../pages/Admin/Agendamentos';

export default function PrivateRoutesAdmin(params) {
    return (
        <Routes>
            <Route path="/admin/agendamentos" element={<AgendamentoPageAdmin />} />
        </Routes>
    )
}