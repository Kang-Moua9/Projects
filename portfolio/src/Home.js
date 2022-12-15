import React from 'react';
import './css/Home.css';

const Home = () => {
    return (
        <div className='Home'>
                <h1 id="welcome">Welcome!</h1>
                <div className="portraitGroup">
                    <p id="firstName">Kang</p>
                    <img id="portraitHome" src={require("./graphic/kang.jpg")} alt="Portrait of Kang Moua"></img>
                    <p id="lastName">Moua</p>
                </div>
                <p id='email'>kang.moua9@gmail.com</p>
                <main>
                    Thank you for taking your time to view my portfolio. Here you will learn about who am I and see my accomplishments.
                    If you are intersted in connecting, please leave your information in the contact tab. I hope to connect with you soon!
                </main>
        </div>
    );
}

export default Home;