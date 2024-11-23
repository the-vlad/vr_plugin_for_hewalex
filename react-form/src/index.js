import React, {useState} from 'react';
import ReactDOM from 'react-dom';
import './index.css';
import axios from 'axios';
import FirstStep from "./components/FirstStep";
import SecondStep from "./components/SecondStep";
import {Form, Row, Col, Button} from "react-bootstrap";
import validator from 'validator';
import AWN from "awesome-notifications";

let options = {
    position: "bottom-right",
    icons: {
        enabled: false
    },
};
options.labels = {
    success: "SUKCES",
    warning: "UWAGA",
    alert: "BŁĄD",
}


function FormSolar() {

    const lastStage = 2;
    let formData = new FormData();
    const [state, setState] = React.useState({
        currentStage: 1,
        nip: { value: '', isValid: true, message: '' },
        id: { value: '', isValid: true, message: '' },
        id_number_set: { value: '', isValid: true, message: '' },
        number_set: { value: '', isValid: false, message: '' },
        load_nip: { value: '', isValid: false, message: '' },
        email: { value: wp_object.user_email, isValid: true, message: '' },
        user_set_solar_agree: { value: false, isValid: false, message: '' },
        terms_and_condition_agree: { value: false, isValid: false, message: '' },
        cookies_agree: { value: false, isValid: false, message: '' },
        newsletter_agree: { value: false, isValid: false, message: '' },

        address: { value: '', isValid: true, message: '' },
        province: { value: '', isValid: true, message: '' },
        name: { value: '', isValid: true, message: '' },
        postcode: { value: '', isValid: true, message: '' },
        phone: { value: '', isValid: true, message: '' },
        surname: { value: '', isValid: true, message: '' },
        city: { value: '', isValid: true, message: '' },

        number_colector_1: { value: '', isValid: true, message: '' },
        number_colector_2: { value: '', isValid: true, message: '' },
        type_set: { value: '', isValid: true, message: '' },
        points: { value: '', isValid: true, message: '' },
        number_solar: { value: '', isValid: true, message: '' },
        number_solar_pump: { value: '', isValid: true, message: '' },
        source_pay: { value: '', isValid: true, message: '' },
        number_driver: { value: '', isValid: true, message: '' },
        date_pay: { value: '', isValid: true, message: '' },

        userchecked: { value: '', isValid: true, message: '' },
        installator_postcode: { value: '', isValid: false, message: '' },
        installator_phone: { value: '', isValid: false, message: '' },
        installator_name: { value: '', isValid: false, message: '' },
        installator_city: { value: '', isValid: false, message: '' },
        installator_email: { value: '', isValid: false, message: '' },
        installator_address: { value: '', isValid: false, message: '' },
        installator_province: { value: '', isValid: false, message: '' },
        installator: { value: '', isValid: false, message: '' },

        valid: false
    })

    const handleSubmit = (event) => {
        event.preventDefault();
        // saveForm(event);

        if (!formIsValid()) {
            event.preventDefault();
            new AWN().warning('Sprawdź poprawność pól', options);  
            return;
        }
        
        saveForm(event);
        
    };

    const handleChange = (event) => {
        setState({
            ...state,
            [event.target.name]: {
                ...state[event.target.name],
                value: event.target.value
            }
        });
        validateFormInstallator();
    }

    const validateFormInstallator = () => {
        const currentStage = state.currentStage;
        const valid = state.valid;
        const nip = { ...state.nip };
        const installator_postcode = { ...state.installator_postcode };
        const installator_phone = { ...state.installator_phone };
        const installator_name = { ...state.installator_name };
        const installator_city = { ...state.installator_city };
        const installator_email = { ...state.installator_email };
        const installator_address = { ...state.installator_address };
        const installator_province = { ...state.installator_province };

        for (const [key, value] of Object.entries(state)) {
            if (!validator.isEmpty(installator_postcode.value) &&
                !validator.isEmpty(nip.value) &&
                !validator.isEmpty(installator_phone.value) &&
                !validator.isEmpty(installator_name.value) &&
                !validator.isEmpty(installator_city.value) &&
                !validator.isEmpty(installator_email.value) &&
                !validator.isEmpty(installator_address.value) &&
                !validator.isEmpty(installator_province.value) &&
                currentStage === 2) {
                return false;
            }
            else {
                return true;
            }
        }
    }

    const saveForm = (event) => {
        for (const [key, value] of Object.entries(state)) {

            if(typeof value === 'object' && value !== null){
                let value_from_state =  Object.values(value);
                formData.append(key, value_from_state[0]);
            }
            else {
               formData.append(key, value);
            }
        }
        formData.append('action', 'SaveForm');

        try {
            axios
                .post(wp_object.ajax_url, formData)
                .then(
                    (response) =>{
                        console.log(response.data);

                        let findStatus = response.data;
                        if (findStatus.includes('updated')) {
                            new AWN().success('Dane zostały zaktualizowane', options);
                            document.getElementById("submitSolar").disabled = true;
                            setInterval('window.location.reload()', 3700);
                        }
                        
                        if (findStatus.includes('true') && !findStatus.includes('updated')) { 
                            new AWN().success('Rejestracja zestawu przebiegła pomyślnie!', options);
                            document.getElementById("submitSolar").disabled = true;
                            setInterval('window.location.reload()', 3700);
                        }

                        if (findStatus.includes('generated PDF') && response.status === 200) {
                            new AWN().success('Rejestracja zestawu przebiegła pomyślnie!', options);
                            document.getElementById("submitSolar").disabled = true;
                            setInterval('window.location.reload()', 3700);
                        }

                        // this.setState({
                        //     nip: response.data.nip.toString()
                        // });
                    }
                )
        } catch(e) {
            console.error(e.message);
        }
    }

    const formIsValid= () => {
        const number_set = { ...state.number_set };
        // const currentStage = { ...state.currentStage };
        const id = { ...state.id };
        const currentStage = state.currentStage;
        const email = { ...state.email };
        const user_set_solar_agree = { ...state.user_set_solar_agree };
        const terms_and_condition_agree = { ...state.terms_and_condition_agree };
        const cookies_agree = { ...state.cookies_agree };
        const newsletter_agree = { ...state.newsletter_agree };
        const address = { ...state.address };
        const province = { ...state.province };
        const name = { ...state.name };
        const postcode = { ...state.postcode };
        const phone = { ...state.phone };
        const surname = { ...state.surname };
        const city = { ...state.city };
        const number_colector_1 = { ...state.number_colector_1 };
        const number_colector_2 = { ...state.number_colector_2 };
        const type_set = { ...state.type_set };
        const number_solar = { ...state.number_solar };
        const number_solar_pump = { ...state.number_solar_pump };
        const source_pay = { ...state.source_pay };
        const number_driver = { ...state.number_driver };
        const date_pay = { ...state.date_pay };
        const installator = { ...state.installator };
        const installator_postcode = { ...state.installator_postcode };
        const installator_phone = { ...state.installator_phone };
        const installator_name = { ...state.installator_name };
        const installator_city = { ...state.installator_city };
        const installator_email = { ...state.installator_email };
        const installator_address = { ...state.installator_address };
        const installator_province = { ...state.installator_province };
        let load_nip = { ...state.load_nip};
        let userchecked = { ...state.userchecked};
        const nip = { ...state.nip };
        const valid = state.valid;
        const points = { ...state.points };
        const id_number_set = { ...state.id_number_set };

        let isGood = true;

        // console.log(currentStage);
        for (const [key, value] of Object.entries(state)) {

            // if (!validator.isLength(number_set.value, {min:5, max: 5}) && currentStage === 1) {
            //     number_set.isValid = false;
            //     number_set.message = <div class="notification-alert">Kod niepoprawny</div>;
            //     isGood = false;
            // }
            
            // if (validator.isLength(number_set.value, {min:0, max: 0}) && currentStage === 1) {
            //     number_set.isValid = false;
            //     number_set.message = <div class="notification-warning">Pole jest puste</div>;
            //     isGood = false;
            // }

            if (user_set_solar_agree.value == false && currentStage === 1) {
                user_set_solar_agree.isValid = false;
                user_set_solar_agree.message = <div class="notification-alert">Zgoda jest wymagana</div>
                isGood = false;
            }
            else{
                user_set_solar_agree.message = ''
            }

            // if (userchecked.value) {
            //     userchecked.isValid = false;
            //     // load_nip.message = <div class="notification-alert">Pole jest wymagane</div>
            //     isGood = false;
            // }

            if (terms_and_condition_agree.value == false && currentStage === 1) {
                terms_and_condition_agree.isValid = false;
                terms_and_condition_agree.message = <div class="notification-alert">Zgoda jest wymagana</div>
                isGood = false;
            }
            else{
                terms_and_condition_agree.message = ''
            }

            if (cookies_agree.value == false && currentStage === 1) {
                cookies_agree.isValid = false;
                cookies_agree.message = <div class="notification-alert">Zgoda jest wymagana</div>
                isGood = false;
            }
            else{
                cookies_agree.message = ''
            }

            if (validator.isEmpty(address.value) && currentStage === 2) {
                address.isValid = false;
                address.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                address.message = ''
            }



            if (validator.isEmpty(province.value) && currentStage === 2) {
                province.isValid = false;
                province.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                province.message = ''
            }

            if (validator.isEmpty(name.value) && currentStage === 2) {
                name.isValid = false;
                name.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                name.message = ''
            }

            if (validator.isEmpty(postcode.value) && currentStage === 2) {
                postcode.isValid = false;
                postcode.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;   
            }
            else{
                postcode.message = ''
            }

            if (validator.isEmpty(phone.value) && currentStage === 2) {
                phone.isValid = false;
                phone.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                phone.message = '' 
            }

            if (load_nip.value  && currentStage === 2) {
                load_nip.isValid = false;
                load_nip.message = <div class="notification-alert">Pole jest wymagane</div>
                // isGood = false;
            }

            if (validator.isEmpty(surname.value) && currentStage === 2) {
                surname.isValid = false;
                surname.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
             
            }
            else{
                surname.message = ''
            }

            if (validator.isEmpty(city.value) && currentStage === 2) {
                city.isValid = false;
                city.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                city.message = ''
            }

            if (validator.isEmpty(number_colector_1.value) && currentStage === 2) {
                number_colector_1.isValid = false;
                number_colector_1.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                number_colector_1.message = ''
            }

            if (validator.isEmpty(number_colector_2.value) && currentStage === 2) {
                number_colector_2.isValid = false;
                number_colector_2.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                number_colector_2.message = '' 
            }

            if (validator.isEmpty(type_set.value) && currentStage === 2) {
                type_set.isValid = false;
                type_set.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }

            if (!id.value  && currentStage === 2) {
                id.isValid = false;
                id.message = <div class="notification-alert">Pole jest wymagane</div>
                // isGood = false;
            }
         

            if (validator.isEmpty(number_solar.value) && currentStage === 2) {
                number_solar.isValid = false;
                number_solar.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                number_solar.message = ''
            }

            if (validator.isEmpty(number_solar_pump.value) && currentStage === 2) {
                number_solar_pump.isValid = false;
                number_solar_pump.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                number_solar_pump.message = '' 
            }

            if (validator.isEmpty(source_pay.value) && currentStage === 2) {
                source_pay.isValid = false;
                source_pay.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else{
                source_pay.message = ''
            }

            if (validator.isEmpty(number_driver.value) && currentStage === 2) {
                number_driver.isValid = false;
                number_driver.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else {
                number_driver.message = '' 
            }

            if (validator.isEmpty(date_pay.value) && currentStage === 2) {
                date_pay.isValid = false;
                date_pay.message = <div class="notification-alert">Pole jest wymagane</div>
                isGood = false;
            }
            else {
                date_pay.message  = '' 
            }

            if (!load_nip.value  && currentStage === 2) {

                    /* Validate NIP FIELDS */
                    
                    // if (validator.isEmpty(installator_postcode.value) && currentStage === 2 && load_nip) {
                    //     installator_postcode.isValid = false;
                    //     installator_postcode.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     installator_postcode.message = ''
                    // }
                    //
                    // if (validator.isEmpty(installator_phone.value) && currentStage === 2) {
                    //     installator_phone.isValid = false;
                    //     installator_phone.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     installator_phone.message = ''
                    // }
                    //
                    //
                    // if (installator_name.value == null && currentStage === 2) {
                    //     installator_name.isValid = false;
                    //     installator_name.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     installator_name.message = ''
                    // }
                    //
                    // if (validator.isEmpty(installator_city.value) && currentStage === 2) {
                    //     installator_city.isValid = false;
                    //     installator_city.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     installator_city.message = ''
                    // }
                    //
                    // if (validator.isEmpty(installator_email.value) && currentStage === 2) {
                    //     installator_email.isValid = false;
                    //     installator_email.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     installator_email.message = ''
                    // }
                    //
                    // if (installator_address.value == null && currentStage === 2) {
                    //     installator_address.isValid = false;
                    //     installator_address.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     installator_address.message = ''
                    // }
                    //
                    // if (validator.isEmpty(installator_province.value) && currentStage === 2) {
                    //     installator_province.isValid = false;
                    //     installator_province.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     installator_province.message = ''
                    // }
                    //
                    // if (nip.value == null && currentStage === 2) {
                    //     nip.isValid = false;
                    //     nip.message = <div class="notification-alert">Pole jest wymagane</div>
                    //     isGood = false;
                    // }
                    // else{
                    //     nip.message = ''
                    // }
            }
         
        }

        // if (!validator.isLength(number_set.value, {min:5, max: 5})) {
        //     number_set.isValid = false;
        //     number_set.message = 'Kod niepoprawny';
        //     isGood = false;
        // }

        if (!isGood) {
            setState({
                currentStage,
                number_set,
                email,
                user_set_solar_agree,
                terms_and_condition_agree,
                cookies_agree,
                newsletter_agree,

                address,
                province,
                name,
                postcode,
                phone,
                surname,
                city,

                number_colector_1,
                number_colector_2,
                type_set,
                points,
                number_solar,
                number_solar_pump,
                source_pay,
                number_driver,
                date_pay,
                id,
                id_number_set,
                installator,
                installator_postcode,
                installator_phone,
                installator_name,
                installator_city,
                installator_email,
                installator_address,
                installator_province,
                load_nip,
                userchecked,
                nip,
                valid
                // ...state,
                // // [event.target.name]
                // [event.target.name]: {
                //     ...state[event.target.name],
                //     message: event.target.message
                // }
            });
        }
       
        return isGood;
    }

    const nextStep = (event, state) => {
        event.preventDefault();
        if (formIsValid()) {
            console.log('jest okay');
            // new AWN().success('Kod jest prawidłowy', options);
            checkCode();
        }
        else {
            // checkCode();
            new AWN().warning('Sprawdź poprawność kodu lub zgod', options);
        }
    }

    const checkCode = (event) => {
        // let formData = new FormData();
        for (const [key, value] of Object.entries(state)) {
            formData.append(key, value.value);
        }
        formData.append('action', 'CheckNumberSet');

        try {
            axios
                .post(wp_object.ajax_url, formData)
                .then(
                    (response) =>{

                        console.log(response.data);

                        if (response.data.code == null){
                            new AWN().alert('Bląd: nieprawidłowy numer.', options);
                        }

                        if (state.number_set.value === response.data.code && response.data.userchecked == true){
                            new AWN().alert('Przepraszamy, instalacja już zarejestrowana', options);
                        }

                        if (state.number_set.value === response.data.code && response.data.userchecked == false || response.data.userchecked == null ) {                      
                            if (state.currentStage < 2) {
                                setState({
                                    ...state,
                                    //status: response.data.code,
                                    currentStage: state.currentStage + 1,
                                    load_nip: {
                                        value: response.data.load_nip,
                                        isValid: false,
                                        message: ''
                                    },
                                    id: {
                                        value: response.data.id,
                                        isValid: false,
                                        message: '',
                                    },
                                    id_number_set: {
                                        value: response.data.id_number_set,
                                        isValid: false,
                                        message: '',
                                    },
                                    userchecked: {
                                        value: response.data.userchecked,
                                        isValid: false,
                                        message: ''
                                    },
                                    type_set: {
                                        value: response.data.type.post_title,
                                        isValid: false,
                                        message: ''
                                    },
                                    points: {
                                        value: response.data.points,
                                        isValid: false,
                                        message: ''
                                    },
                                    // nip: {
                                    //     value: response.data.nip,
                                    //     isValid: false,
                                    //     message: ''
                                    // },
                                    // installator_address: {
                                    //     value: response.data.adres,
                                    //     isValid: false,
                                    //     message: ''
                                    // },
                                    // installator_name: {
                                    //     value: response.data.companyname,
                                    //     isValid: false,
                                    //     message: ''
                                    // },
                                    
                                });
                            }

                        } 
                        // else {   
                        //     console.log('YEYEYEYYE');
                        //     console.log(response.data);
                        //     new AWN().alert('Kod nieprawidłowy', options);
                        // }
                    }
                )
        } catch {
            console.log('Error binding function')
        }
    }
    console.log(state);

    return (
        <>
            <Form
                noValidate
                onSubmit={handleSubmit}
            >
                <FirstStep
                    stage={state.currentStage}
                    number_set={state.number_set}
                    email={state.email}
                    user_set_solar_agree={state.user_set_solar_agree}
                    terms_and_condition_agree={state.terms_and_condition_agree}
                    cookies_agree={state.cookies_agree}
                    newsletter_agree={state.newsletter_agree}
                    handleChange={handleChange}
                />

                <SecondStep
                    load_nip={state.load_nip.value}
                    email={state.email.value}
                    address={state.address}
                    province={state.province}
                    name={state.name}
                    postcode={state.postcode}
                    phone={state.phone}
                    surname={state.surname}
                    city={state.city}

                    number_set={state.number_set.value}
                    number_colector_1={state.number_colector_1}
                    number_colector_2={state.number_colector_2}
                    type_set={state.type_set}
                    number_solar={state.number_solar}
                    number_solar_pump={state.number_solar_pump}
                    source_pay={state.source_pay}
                    number_driver={state.number_driver}
                    date_pay={state.date_pay}

                    installator={state.installator}
                    installator_postcode={state.installator_postcode}
                    installator_phone={state.installator_phone}
                    installator_name={state.installator_name}
                    installator_city={state.installator_city}
                    installator_email={state.installator_email}
                    installator_address={state.installator_address}
                    installator_province={state.installator_province}

                    nip={state.nip}
                    stage={state.currentStage}
                    valid={state.valid}
                    handleChange={handleChange}
                    validateFormInstallator={validateFormInstallator}
                />
                {state.currentStage===lastStage &&
                    <Button id="submitSolar"
                        // stage={state.currentStage}
                        type="submit">
                        Wyślij formularz
                    </Button>
                } 
            </Form>
            {state.currentStage!==lastStage &&
                <Button
                    onClick={nextStep}
                    disabled={state.currentStage === lastStage}>
                    Następny krok
                </Button>
            }
        </>
    );
}

ReactDOM.render(<FormSolar />, document.getElementById('root'));