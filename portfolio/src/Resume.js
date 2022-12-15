import React from "react";
import './css/Resume.css';

const Resume = () => {
    return (
        <div className='Resume'>
            <h1>Resume</h1>
            <iframe src={require("./graphic/2022 Resume - Kang Moua.pdf")} width="50%" height="700px" />
        </div>
    )
}

export default Resume;