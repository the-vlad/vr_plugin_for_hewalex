import { Component } from 'react';
import './App.css';
import axios from 'axios';

class App extends Component {
    render() {
        return (
            <div className="App">
                <ContactForm />
            </div>
        );
    }
}

class ContactForm extends Component{

    constructor(props) {
        super(props);
        this.state = {
            name: '',
            email: wp_object.user_email,
            text: 'Not clicked!'
        }
    }

    handleFormSubmitStep1( event ) {
        event.preventDefault();

        let formData = new FormData();
        formData.append('action', 'processAxioData');
        formData.append('installation_code', this.state.name)
        formData.append('email', this.state.email)

        axios.post(wp_object.ajax_url, formData).then(function(response){
            console.log(response.data);
        })
    }

    render(){
        return(
            <form>
                <label>Name</label>
                <input type="text" name="installation_code" value={this.state.name}
                       onChange={e => this.setState({ name: e.target.value })}/>

                <label>Email</label>
                <input type="email" disabled="disabled" name="email" value={this.state.email}
                       onChange={e => this.setState({ email: e.target.value })}/>

                <input type="submit" onClick={e => this.handleFormSubmitStep1(e)} value="Create Contact" />
            </form>
        );

    }
}

export default App;