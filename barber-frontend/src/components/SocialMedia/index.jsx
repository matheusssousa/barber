import React from "react";

import './style.css';
import { FacebookLogo, InstagramLogo } from "@phosphor-icons/react";

export default function SocialMedia() {
    return (
        <div className="content-social-media">
            <a href="#" className="facebook"><FacebookLogo size={26} weight="fill" /></a>
            <a href="#" className="instagram"><InstagramLogo size={26} weight="fill" /></a>
        </div>
    )
}