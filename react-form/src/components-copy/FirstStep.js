import React from 'react';
import {Form, Row, Col} from "react-bootstrap";

class FirstStep extends React.Component {
    render() {
        if (this.props.stage === 1) {
            return (
                <>
                    <div className="title-fieldset">
                        Rejestracja zestawu solarnego
                    </div>
                    <fieldset className="bootstrap-fieldset">
                        <Row>
                            <Col sm={12}>
                                <Form.Group className="mb-3" controlId="Email">
                                    <Form.Label>Adres e-mail</Form.Label>
                                    <Form.Control
                                        type="email"
                                        placeholder="E-mail"
                                        name="email"
                                        value={this.props.email}
                                        onChange={this.props.handleChange}
                                        disabled
                                    />
                                </Form.Group>
                                <Form.Group className="mb-3" controlId="Code">
                                    <Form.Label>Numer zestawu</Form.Label>
                                    <Form.Control
                                        type="text"
                                        name="number_set"
                                        placeholder="Numer zestawu"
                                        value={this.props.number_set}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                                <Form.Group controlId="UserSetSolar">
                                    <Form.Check
                                        type="checkbox"
                                        name="user_set_solar_agree"
                                        label="Jestem Użytkownikiem zestawu solarnego"
                                        checked={this.props.user_set_solar_agree}
                                        onChange={(e) => {
                                            this.props.handleChange({
                                                target: {
                                                    name: e.target.name,
                                                    value: e.target.checked,
                                                },
                                            });
                                        }}
                                    />
                                </Form.Group>
                                <Form.Group controlId="TermsCondition">
                                    <Form.Check
                                        type="checkbox"
                                        name="terms_and_condition_agree"
                                        label="Akceptuję regulamin programu PPG"
                                        checked={this.props.terms_and_condition_agree}
                                        onChange={(e) => {
                                            this.props.handleChange({
                                                target: {
                                                    name: e.target.name,
                                                    value: e.target.checked,
                                                },
                                            });
                                        }}
                                    />
                                </Form.Group>
                                <Form.Group controlId="Cookies">
                                    <Form.Check
                                        type="checkbox"
                                        name="cookies_agree"
                                        label="Zapoznałem się z informacją o administratorze i przetwarzaniu danych."
                                        checked={this.props.cookies_agree}
                                        onChange={(e) => {
                                            this.props.handleChange({
                                                target: {
                                                    name: e.target.name,
                                                    value: e.target.checked,
                                                },
                                            });
                                        }}
                                    />
                                </Form.Group>
                                <Form.Group controlId="Newsletter">
                                    <Form.Check
                                        type="checkbox"
                                        name="newsletter_agree"
                                        label="Chcę otrzymywać newsletter"
                                        checked={this.props.newsletter_agree}
                                        onChange={(e) => {
                                            this.props.handleChange({
                                                target: {
                                                    name: e.target.name,
                                                    value: e.target.checked,
                                                },
                                            });
                                        }}
                                    />
                                </Form.Group>
                            </Col>
                        </Row>
                    </fieldset>
                </>
                // <div>
                //     <label htmlFor="form__email">Email</label>
                //     <input
                //         type="text"
                //         name="email"
                //         id="form__email"
                //         placeholder="Email"
                //         value={this.props.email}
                //         onChange={this.props.handleChange}
                //     />
                //     <label htmlFor="form__name">Name</label>
                //     <input
                //         type="text"
                //         name="name"
                //         id="form__name"
                //         placeholder="Name"
                //         value={this.props.name}
                //         onChange={this.props.handleChange}
                //     />
                // </div>
            );
        }
        else {
            return null;
        }
    }
}

export default FirstStep;