import React from "react";
import './css/AboutMe.css';

const AboutMe = () => {
    return (
        <div className='AboutMe'>
                <div className="container1">
                    <img id="portraitAboutMe" src={require("./graphic/kang.jpg")} alt="Portrait of Kang Moua"></img>
                </div>
                <div className="container2">
                    <main id="info">
                        <ul id="list">
                            <li><b>Full Name:</b> Kang Moua</li>
                            <li><b>Age:</b> 21</li>
                            <li><b>School:</b> Concordia University, St. Paul</li>
                            <li><b>Major:</b> Bachelor of Computer Science</li>
                            <li><b>Year:</b> May 2022</li>
                        </ul>
                    </main>
                </div>
                <div className="container3">
                    <main id="aboutMe">
                        <h1>About Me</h1>
                        I am an aspiring developer looking to grow through my career and connections. Much of my
                        interests stem from my early childhood appeal of the technology bloom as well as what could
                        be built using these advancements in applications, tools, and services. This has led me to
                        my degree and gear me towards an everchanging field where one is constantly learning and
                        revising the latest updates and developements. I do hope to expand my knowledge and experience
                        with tech as it is still early in my career phase.
                    </main>
                </div>
                <div className="container4">
                    <img id="familyImg" src={require("./graphic/family.jpg")} />
                </div>
                <div className="container5">
                    <main id="aboutMe">
                        <h1>Family</h1>
                    </main>
                </div>
                <div className="container6">
                    <main id="info">
                        <h2>Hobbies and Interests</h2>
                        <ul id="list">
                            <li>Art</li>
                            <li>Music</li>
                            <li>Video Production</li>
                            <li>Video Games</li>
                        </ul>
                    </main>
                </div>
                <div className="container7">
                    <img id="hobbyImg" src={require("./graphic/hobby.jpg")} />
                </div>
        </div>
    )
}

export default AboutMe;