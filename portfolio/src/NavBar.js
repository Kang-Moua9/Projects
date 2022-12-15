import React from "react";
import { BrowserRouter as Router, Route, Routes, Link } from "react-router-dom";
import './css/NavBar.css';

const NavBar = () => {
    return (
        <div className='NavBar'>
            <div id="navi">
                <Link to="/">Home</Link>
                <Link to="/AboutMe">About Me</Link>
                <Link to="/Resume">Resume</Link>
                <Link to="/Project">Project</Link>
                <Link to="/Contact">Contact</Link>
            </div>
        </div>
    )
}

export default NavBar;