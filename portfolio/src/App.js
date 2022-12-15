import React from "react";
import NavBar from "./NavBar";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import Home from "./Home";
import AboutMe from "./AboutMe";
import Resume from "./Resume";
import Project from "./Project";
import Contact from "./Contact";
import Footer from "./Footer";
import './css/App.css';
import './css/Style.css';


const App = () => {
    return (
        <div className="App">
            <Router>
                <NavBar />
                <Routes>
                    <Route path='/' element={<Home />} />
                    <Route path='/AboutMe' element={<AboutMe />} />
                    <Route path='/Resume' element={<Resume />} />
                    <Route path='/Project' element={<Project />} />
                    <Route path='/Contact' element={<Contact />} />
                </Routes>
            </Router>
            <Footer/>
        </div>
    );
}

export default App;