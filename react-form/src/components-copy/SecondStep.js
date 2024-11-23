import React from 'react';
import {Form, Row, Col} from "react-bootstrap";

class SecondStep extends React.Component {
    render() {
        if (this.props.stage === 2) {
            return (
                <>
                    <div className="title-fieldset">
                        Dane klienta
                    </div>
                    <fieldset className="bootstrap-fieldset">
                        <Row>
                            <Col sm={4}>
                                <Form.Group controlId="Email">
                                    <Form.Label>Email address</Form.Label>
                                    <Form.Control
                                        type="email"
                                        placeholder="E-mail"
                                        name="email"
                                        value={this.props.email}
                                        onChange={this.props.handleChange}
                                        disabled
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="Address">
                                    <Form.Label>Adres</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Adres"
                                        name="address"
                                        value={this.props.address}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="Wojewodztwo">
                                    <Form.Label>Województwo</Form.Label>
                                    <Form.Select
                                        className="form-control"
                                        aria-label="Wojewodztwo"
                                        name="province"
                                        onChange={this.props.handleChange}
                                        value={this.props.province}
                                    >
                                        <option>wybierz województwo</option>
                                        <option value="slaskie">Śląskie</option>
                                        <option value="dolnoslaskie">Dolnośląskie</option>
                                        <option value="kujawskopomorskie">Kujawsko-Pomorskie</option>
                                        <option value="lubelskie">Lubelskie</option>
                                        <option value="lubuskie">Lubuskie</option>
                                        <option value="lodzkie">Łódzkie</option>
                                        <option value="malopolskie">Małopolskie</option>
                                        <option value="mazowieckie">Mazowieckie</option>
                                        <option value="opolskie">Opolskie</option>
                                        <option value="podkarpackie">Podkarpackie</option>
                                        <option value="podlaskie">Podlaskie</option>
                                        <option value="pomorskie">Pomorskie</option>
                                        <option value="swietokrzyskie">Świętokrzyskie</option>
                                        <option value="warminskomazurskie">Warmińsko-Mazurskie</option>
                                        <option value="wielkopolskie">Wielkopolskie</option>
                                        <option value="zachodniopomorskie">Zachodniopomorskie</option>
                                    </Form.Select>
                                </Form.Group>
                            </Col>
                        </Row>
                        <Row>
                            <Col sm={4}>
                                <Form.Group controlId="Name">
                                    <Form.Label>Imię</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Imię"
                                        name="name"
                                        value={this.props.name}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="postcode">
                                    <Form.Label>Kod pocztowy</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Kod pocztowy"
                                        name="postcode"
                                        value={this.props.postcode}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="Phone">
                                    <Form.Label>Numer telefonu</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer telefonu"
                                        name="phone"
                                        value={this.props.phone}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                        </Row>
                        <Row>
                            <Col sm={4}>
                                <Form.Group controlId="Surname">
                                    <Form.Label>Nazwisko</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Nazwisko"
                                        name="surname"
                                        value={this.props.surname}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="City">
                                    <Form.Label>Miejscowość</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Miejscowość"
                                        name="city"
                                        value={this.props.city}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                        </Row>
                    </fieldset>

                    <div className="title-fieldset">
                        Dane produktu
                    </div>
                    <fieldset className="bootstrap-fieldset">
                        <Row>
                            <Col sm={4}>
                                <Form.Group controlId="NumberSet">
                                    <Form.Label>Numer zestawu</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer zestawu"
                                        name="number_set"
                                        value={this.props.number_set}
                                        onChange={this.props.handleChange}
                                        disabled
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="NumberColector1">
                                    <Form.Label>Numer kolektora 1</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer kolektora 1:"
                                        name="number_colector_1"
                                        value={this.props.number_colector_1}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="NumberColector2">
                                    <Form.Label>Numer kolektora 2</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer kolektora 2:"
                                        name="number_colector_2"
                                        value={this.props.number_colector_2}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                        </Row>
                        <Row>
                            <Col sm={4}>
                                <Form.Group controlId="TypeSet">
                                    <Form.Label>Typ zestawu</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Typ zestawu"
                                        name="type_set"
                                        value={this.props.type_set}
                                        onChange={this.props.handleChange}
                                        disabled
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="NumberSolar">
                                    <Form.Label>Numer podgrzewacza</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer podgrzewacza"
                                        name="number_solar"
                                        value={this.props.number_solar}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="NumberSolarPump">
                                    <Form.Label>Numer zespołu pompowego</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer zespołu pompowego"
                                        name="number_solar_pump"
                                        value={this.props.number_solar_pump}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                        </Row>
                        <Row>
                            <Col sm={4}>
                                <Form.Group controlId="Source">
                                    <Form.Label>Źródło zakupu:</Form.Label>
                                    <Form.Select
                                        className="form-control"
                                        aria-label="Source"
                                        name="source_pay"
                                        onChange={this.props.handleChange}
                                        value={this.props.source_pay}
                                    >
                                        <option>Wybierz</option>
                                        <option value="hurtownia">Hurtownia</option>
                                        <option value="instalator">Instalator</option>
                                        <option value="internet">Internet</option>
                                    </Form.Select>
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="NumberDriver">
                                    <Form.Label>Numer sterownika:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer sterownika:"
                                        name="number_driver"
                                        value={this.props.number_driver}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="DatePay">
                                    <Form.Label>Data zakupu:</Form.Label>
                                    <Form.Control
                                        type="date"
                                        placeholder="Data zakupu:"
                                        name="date_pay"
                                        value={this.props.date_pay}
                                        onChange={this.props.handleChange}
                                    />
                                </Form.Group>
                            </Col>
                        </Row>
                    </fieldset>

                    <div className="title-fieldset">
                        Dane instalatora
                    </div>
                    <fieldset className="bootstrap-fieldset">
                        <Row>
                            <Col sm={12}>
                                <Form.Group controlId="AssignInstallator">
                                    <Form.Check
                                        type="checkbox"
                                        name="installator"
                                        label="Powiązać konto z instalatorem?"
                                        checked={this.props.installator}
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
                        { !this.props.nip &&
                            <>
                                <Row>
                                    <Col sm={4}>
                                        <Form.Group controlId="NIP">
                                            <Form.Label>NIP:</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="NIP:"
                                                name="nip"
                                                value={this.props.nip}
                                                onChange={this.props.handleChange}
                                            />
                                        </Form.Group>
                                    </Col>
                                    <Col sm={4}>
                                        <Form.Group controlId="InstallatorPostCode">
                                            <Form.Label>Kod pocztowy:</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Kod pocztowy:"
                                                name="installator_postcode"
                                                value={this.props.installator_postcode}
                                                onChange={this.props.handleChange}
                                            />
                                        </Form.Group>
                                    </Col>
                                    <Col sm={4}>
                                        <Form.Group controlId="InstallatorPhone">
                                            <Form.Label>Numer telefonu:</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Numer telefonu:"
                                                name="installator_phone"
                                                value={this.props.installator_phone}
                                                onChange={this.props.handleChange}
                                            />
                                        </Form.Group>
                                    </Col>
                                </Row>
                                <Row>
                                    <Col sm={4}>
                                        <Form.Group controlId="InstallatorName">
                                            <Form.Label>Nazwa:</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Nazwa:"
                                                name="installator_name"
                                                value={this.props.installator_name}
                                                onChange={this.props.handleChange}
                                            />
                                        </Form.Group>
                                    </Col>
                                    <Col sm={4}>
                                        <Form.Group controlId="InstallatorCity">
                                            <Form.Label>Miejscowość:</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Miejscowość:"
                                                name="installator_city"
                                                value={this.props.installator_city}
                                                onChange={this.props.handleChange}
                                            />
                                        </Form.Group>
                                    </Col>
                                    <Col sm={4}>
                                        <Form.Group controlId="InstallatorEmail">
                                            <Form.Label>E-mail:</Form.Label>
                                            <Form.Control
                                                type="email"
                                                placeholder="E-mail:"
                                                name="installator_email"
                                                value={this.props.installator_email}
                                                onChange={this.props.handleChange}
                                            />
                                        </Form.Group>
                                    </Col>
                                </Row>
                                <Row>
                                    <Col sm={4}>
                                        <Form.Group controlId="InstallatorAddress">
                                            <Form.Label>Adres:</Form.Label>
                                            <Form.Control
                                                type="text"
                                                placeholder="Adres:"
                                                name="installator_address"
                                                value={this.props.installator_address}
                                                onChange={this.props.handleChange}
                                            />
                                        </Form.Group>
                                    </Col>
                                    <Col sm={4}>
                                        <Form.Group controlId="InstallatorWojewodztwo">
                                            <Form.Label>Województwo</Form.Label>
                                            <Form.Select
                                                className="form-control"
                                                aria-label="Wojewodztwo"
                                                name="installator_province"
                                                onChange={this.props.handleChange}
                                                value={this.props.installator_province}
                                            >
                                                <option>wybierz województwo</option>
                                                <option value="slaskie">Śląskie</option>
                                                <option value="dolnoslaskie">Dolnośląskie</option>
                                                <option value="kujawskopomorskie">Kujawsko-Pomorskie</option>
                                                <option value="lubelskie">Lubelskie</option>
                                                <option value="lubuskie">Lubuskie</option>
                                                <option value="lodzkie">Łódzkie</option>
                                                <option value="malopolskie">Małopolskie</option>
                                                <option value="mazowieckie">Mazowieckie</option>
                                                <option value="opolskie">Opolskie</option>
                                                <option value="podkarpackie">Podkarpackie</option>
                                                <option value="podlaskie">Podlaskie</option>
                                                <option value="pomorskie">Pomorskie</option>
                                                <option value="swietokrzyskie">Świętokrzyskie</option>
                                                <option value="warminskomazurskie">Warmińsko-Mazurskie</option>
                                                <option value="wielkopolskie">Wielkopolskie</option>
                                                <option value="zachodniopomorskie">Zachodniopomorskie</option>
                                            </Form.Select>
                                        </Form.Group>
                                    </Col>
                                </Row>
                            </>
                        }
                        <Row>
                            <Col sm={12}>
                                <div>Dane instalatora</div>
                                <div>{this.props.nip}</div>
                            </Col>
                        </Row>
                    </fieldset>
                </>
            );
        } else {
            return null;
        }
    }
}

export default SecondStep;