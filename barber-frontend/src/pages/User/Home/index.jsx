import React from "react";

import "./style.css";
import SocialMedia from "../../../components/SocialMedia";

export default function Home() {
    return (
        <div className="page-body-home">
            <div className="content-informations">
                    <h1>THE BARBERSHOP</h1>
                    <h2>EXPERT HARICUTS AND GROOMING SERVICES</h2>
                    <p>At The Finest Barbershop, we offer a wide range of professional hair cutting and grooming services for men. Our experienced barbers use the latest techniques and tools to give you the perfect look. Whether you're in need of a classic haircut, straight razor shave, or beard trim, we've got you covered.</p>
                <div className="content-button-info-home">
                    <button className="btn-info-primary">BOOK A HARICUT</button>
                    <button className="btn-info-second">AGENDAR</button>
                </div>
                <SocialMedia/>
            </div>
        </div>
    )
}