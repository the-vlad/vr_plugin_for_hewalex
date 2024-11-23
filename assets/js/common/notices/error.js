import AWN from "awesome-notifications";

let options = {
    position: "bottom-right",
    icons: {
        enabled: false
    }
};

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector(".notices--error")) {
        new AWN().alert('Nie masz uprawnień do tej strefy', options);
    }
});