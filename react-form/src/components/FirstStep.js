import React from "react";
import { Form, Row, Col } from "react-bootstrap";
import { Feedback } from "react-bootstrap/Feedback";

const FirstStep = (props) => {
  if (props.stage === 1) {
    return (
      <>
        <div className="title-fieldset">Rejestracja zestawu solarnego</div>
        <fieldset className="bootstrap-fieldset">
          <Row>
            <Col sm={12}>
              <Row className="intro-register_row">
                <Form.Group
                  className="email_set_register mb-3"
                  controlId="Email"
                >
                  <Form.Label>Adres e-mail</Form.Label>
                  <Form.Control
                    required
                    type="email"
                    placeholder="E-mail"
                    name="email"
                    value={props.email.value}
                    onChange={props.handleChange}
                    disabled
                  />
                  <span className="help-block">{props.email.message}</span>
                </Form.Group>
                <Form.Group
                  className="number_set_register mb-3"
                  controlId="Code"
                >
                  <Form.Label>Numer zestawu</Form.Label>
                  <Form.Control
                    className="number_set"
                    required
                    type="text"
                    name="number_set"
                    placeholder="Numer zestawu"
                    value={props.number_set.value}
                    onChange={props.handleChange}
                  />
                  <span className="help-block">{props.number_set.message}</span>
                </Form.Group>
              </Row>
              <Form.Group controlId="UserSetSolar">
                <Form.Check
                  required
                  type="checkbox"
                  name="user_set_solar_agree"
                  label="Jestem Użytkownikiem zestawu solarnego"
                  checked={props.user_set_solar_agree.value}
                  onChange={(e) => {
                    props.handleChange({
                      target: {
                        name: e.target.name,
                        value: e.target.checked,
                      },
                    });
                  }}
                />
                <span className="help-block">
                  {props.user_set_solar_agree.message}
                </span>
              </Form.Group>
              <Form.Group controlId="TermsCondition">
                <Form.Check
                  required
                  type="checkbox"
                  name="terms_and_condition_agree"
                  label={
                    <label>
                      Akceptuję{" "}
                      <a href="https://www.hewalex.pl/regulamin-ppg">
                        regulamin programu PPG
                      </a>
                    </label>
                  }
                  checked={props.terms_and_condition_agree.value}
                  onChange={(e) => {
                    props.handleChange({
                      target: {
                        name: e.target.name,
                        value: e.target.checked,
                      },
                    });
                  }}
                />
                <span className="help-block">
                  {props.terms_and_condition_agree.message}
                </span>
              </Form.Group>
              <Form.Group controlId="Cookies">
                <Form.Check
                  required
                  type="checkbox"
                  name="cookies_agree"
                  label={
                    <label>
                      Zapoznałem się z informacją o{" "}
                      <a href="https://www.hewalex.pl/polityka-prywatnosci-2/">
                        administratorze i przetwarzaniu danych.
                      </a>
                    </label>
                  }
                  checked={props.cookies_agree.value}
                  onChange={(e) => {
                    props.handleChange({
                      target: {
                        name: e.target.name,
                        value: e.target.checked,
                      },
                    });
                  }}
                />
                <span className="help-block">
                  {props.cookies_agree.message}
                </span>
              </Form.Group>
              <Form.Group controlId="Newsletter">
                <Form.Check
                  type="checkbox"
                  name="newsletter_agree"
                  label="Chcę otrzymywać newsletter"
                  checked={props.newsletter_agree.value}
                  onChange={(e) => {
                    props.handleChange({
                      target: {
                        name: e.target.name,
                        value: e.target.checked,
                      },
                    });
                  }}
                />
                <span className="help-block">
                  {props.newsletter_agree.message}
                </span>
              </Form.Group>
            </Col>
          </Row>
        </fieldset>
      </>
    );
  } else {
    return null;
  }
};

export default FirstStep;
