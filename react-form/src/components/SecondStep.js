import React from 'react';
import {Form, Row, Col} from "react-bootstrap";

const SecondStep = (props) => {
    if (props.stage === 2) {
        return (
            <>
            <div className="title-fieldset">
                    Dane klienta
                </div>
                <fieldset className="second-register_row bootstrap-fieldset">
                    <Row>
                        <Col sm={4}>
                            <Form.Group controlId="Email">
                                <Form.Label>Email address</Form.Label>
                                <Form.Control
                                    type="email"
                                    placeholder="E-mail"
                                    name="email"
                                    value={props.email}
                                    onChange={props.handleChange}
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
                                    value={props.address.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.address.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="Wojewodztwo">
                                <Form.Label>Województwo</Form.Label>
                                <Col className="select-group">
                                <Form.Select
                                    className="form-control"
                                    aria-label="Wojewodztwo"
                                    name="province"
                                    onChange={props.handleChange}
                                    value={props.province.value}
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
                                </Col>
                                <span className="help-block">{props.province.message}</span>
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
                                    value={props.name.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.name.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="postcode">
                                <Form.Label>Kod pocztowy</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Kod pocztowy"
                                    name="postcode"
                                    value={props.postcode.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.postcode.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="Phone">
                                <Form.Label>Numer telefonu</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Numer telefonu"
                                    name="phone"
                                    value={props.phone.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.phone.message}</span>
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
                                    value={props.surname.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.surname.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="City">
                                <Form.Label>Miejscowość</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Miejscowość"
                                    name="city"
                                    value={props.city.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.city.message}</span>
                            </Form.Group>
                        </Col>
                    </Row>
                </fieldset>

                <div className="title-fieldset">
                    Dane produktu
                </div>
                <fieldset className="bootstrap-fieldset second-register_row">
                    <Row>
                        <Col sm={4}>
                            <Form.Group controlId="NumberSet">
                                <Form.Label>Numer zestawu</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Numer zestawu"
                                    name="number_set"
                                    value={props.number_set}
                                    onChange={props.handleChange}
                                    disabled
                                />
                                <span className="help-block">{props.number_set.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="NumberColector1">
                                <Form.Label>Numer kolektora 1</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Numer kolektora 1:"
                                    name="number_colector_1"
                                    value={props.number_colector_1.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.number_colector_1.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="NumberColector2">
                                <Form.Label>Numer kolektora 2</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Numer kolektora 2:"
                                    name="number_colector_2"
                                    value={props.number_colector_2.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.number_colector_2.message}</span>
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
                                    value={props.type_set.value}
                                    onChange={props.handleChange}
                                    disabled={props.type_set.value ? "disabled" : ""}
                                />
                                <span className="help-block">{props.type_set.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="NumberSolar">
                                <Form.Label>Numer podgrzewacza</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Numer podgrzewacza"
                                    name="number_solar"
                                    value={props.number_solar.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.number_solar.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="NumberSolarPump">
                                <Form.Label>Numer zespołu pompowego</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Numer zespołu pompowego"
                                    name="number_solar_pump"
                                    value={props.number_solar_pump.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.number_solar_pump.message}</span>
                            </Form.Group>
                        </Col>
                    </Row>
                    <Row>
                        <Col sm={4}>
                            <Form.Group controlId="Source">
                                <Form.Label>Źródło zakupu:</Form.Label>
                                <Col className="select-group">
                                <Form.Select
                                    className="form-control"
                                    aria-label="Source"
                                    name="source_pay"
                                    onChange={props.handleChange}
                                    value={props.source_pay.value}
                                >
                                    <option>Wybierz</option>
                                    <option value="hurtownia">Hurtownia</option>
                                    <option value="instalator">Instalator</option>
                                    <option value="internet">Internet</option>
                                </Form.Select>
                                </Col>
                                <span className="help-block">{props.source_pay.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="NumberDriver">
                                <Form.Label>Numer sterownika:</Form.Label>
                                <Form.Control
                                    type="text"
                                    placeholder="Numer sterownika:"
                                    name="number_driver"
                                    value={props.number_driver.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.number_driver.message}</span>
                            </Form.Group>
                        </Col>
                        <Col sm={4}>
                            <Form.Group controlId="DatePay">
                                <Form.Label>Data zakupu:</Form.Label>
                                <Form.Control
                                    type="date"
                                    placeholder="Data zakupu:"
                                    name="date_pay"
                                    value={props.date_pay.value}
                                    onChange={props.handleChange}
                                />
                                <span className="help-block">{props.date_pay.message}</span>
                            </Form.Group>
                        </Col>
                    </Row>
                </fieldset>

                <div className="title-fieldset">
                    Dane instalatora
                </div>
        
                <fieldset className="bootstrap-fieldset second-register_row second-register_row-3">
                    <Row className="form-check_instalator">
                        <Col sm={12}>
                            <Form.Group controlId="AssignInstallator">
                                <Form.Check
                                    type="checkbox"
                                    name="installator"
                                    label="Powiązać konto z instalatorem?"
                                    checked={props.installator.value}
                                    onChange={(e) => {
                                        props.handleChange({
                                            target: {
                                                name: e.target.name,
                                                value: e.target.checked,
                                            },
                                        });
                                    }}
                                    disabled={props.validateFormInstallator()}

                                    // disabled={(e) => {
                                    //     props.handleChange({
                                    //         target: {
                                    //             name: e.target.name,
                                    //             value: e.target.checked,
                                    //         },
                                    //     });
                                    // }}
                                />
                            </Form.Group>
                        </Col>
                    </Row>
             
                   {!props.load_nip &&
                    <>
                        <Row>
                            <Col sm={4}>
                                <Form.Group controlId="NIP">
                                    <Form.Label>NIP:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="NIP:"
                                        name="nip"
                                        value={props.nip.value}
                                        onChange={props.handleChange}
                                    />
                                  <span className="help-block">{props.nip.message}</span>
                                </Form.Group>
                             
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="InstallatorPostCode">
                                    <Form.Label>Kod pocztowy:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Kod pocztowy:"
                                        name="installator_postcode"
                                        value={props.installator_postcode.value}
                                        onChange={props.handleChange}
                                    />
                                      <span className="help-block">{props.installator_postcode.message}</span>
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="InstallatorPhone">
                                    <Form.Label>Numer telefonu:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Numer telefonu:"
                                        name="installator_phone"
                                        value={props.installator_phone.value}
                                        onChange={props.handleChange}
                                    />
                                    <span className="help-block">{props.installator_phone.message}</span>
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
                                        value={props.installator_name.value}
                                        onChange={props.handleChange}
                                    />
                                    <span className="help-block">{props.installator_name.message}</span>
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="InstallatorCity">
                                    <Form.Label>Miejscowość:</Form.Label>
                                    <Form.Control
                                        type="text"
                                        placeholder="Miejscowość:"
                                        name="installator_city"
                                        value={props.installator_city.value}
                                        onChange={props.handleChange}
                                    />
                                    <span className="help-block">{props.installator_city.message}</span>
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="InstallatorEmail">
                                    <Form.Label>E-mail:</Form.Label>
                                    <Form.Control
                                        type="email"
                                        placeholder="E-mail:"
                                        name="installator_email"
                                        value={props.installator_email.value}
                                        onChange={props.handleChange}
                                    />
                                    <span className="help-block">{props.installator_email.message}</span>
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
                                        value={props.installator_address.value}
                                        onChange={props.handleChange}
                                    />
                                <span className="help-block">{props.installator_address.message}</span>
                                </Form.Group>
                            </Col>
                            <Col sm={4}>
                                <Form.Group controlId="InstallatorWojewodztwo">
                                    <Form.Label>Województwo</Form.Label>
                                    <Col className="select-group">
                                    <Form.Select
                                        className="form-control"
                                        aria-label="Wojewodztwo"
                                        name="installator_province"
                                        onChange={props.handleChange}
                                        value={props.installator_province.value}
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
                                    </Col>
                                    <span className="help-block">{props.installator_province.message}</span>
                                </Form.Group>
                            </Col>
                        </Row>
                    </>
                     }
  
                    {props.load_nip && 
                        <Row>
                            <Col sm={12}>
                                <div>Dane instalatora</div>
                                <div>{props.nip.value}</div>
                                <div>{props.installator_name.value}</div>
                                <div>{props.installator_postcode.value} {props.installator_city.value}</div>
                                <div>{props.installator_address.value}</div>
                            </Col>
                        </Row>
                         }
                </fieldset>
            </>
        );
    } else {
        return null;
    }
}

export default SecondStep;