import React from "react";
import './css/Contact.css';

const Contact = () => {
    return (
        <div className='Contact'>
            <h1>Contact</h1>
            <form id="contactForm">
                <fieldset id="field">
                    <div className="label">
                        <label htmlFor="txtFName">First Name <b style={{color: "red"}}>*</b></label>
                        <input type="text" name="txtFName" id="txtFName" className="txtField" />
                    </div>
                    <div className="label">
                        <label htmlFor="txtLName">Last Name <b style={{color: "red"}}>*</b></label>
                        <input type="text" name="txtLName" id="txtLName" className="txtField" />
                    </div>
                    <div className="label">
                        <label htmlFor="txtEmail">Email <b style={{color: "red"}}>*</b></label>
                        <input type="text" name="txtEmail" id="txtEmail" className="txtField" />
                    </div>
                    <div className="label">
                        <label htmlFor="txtPhone">Phone</label>
                        <input type="text" name="txtPhone" id="txtPhone" className="txtField" />
                    </div>
                    <div className="label">
                        <label htmlFor="txtReason">Reason<b style={{color: "red"}}>*</b></label>
                        <input type="text" name="txtReason" id="txtReason" className="txtField" />
                    </div>
                    <button name="btnSubmit" id="submitButton" value="submit">
                    Submit
                </button>
                </fieldset>
            </form>
        </div>
    )
}

export default Contact;