import React from "react";
import { Navigate, Route, Routes } from "react-router-dom";

import Home from "../pages/User/Home";
import PageLoginAdmin from "../pages/Admin/Auth/Login";
import PageLoginUser from "../pages/User/Auth/Login";

export default function PublicRoutes() {
    return (
        <Routes>
            <Route path="*" element={<Navigate to='/' />} />
            <Route path="/" element={<Home />} />
            <Route path="/admin" element={<PageLoginAdmin />} />
            <Route path="/login" element={<PageLoginUser />} />
        </Routes>
    )
}