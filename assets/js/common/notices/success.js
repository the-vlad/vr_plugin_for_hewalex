import AWN from "awesome-notifications";

let options = {
    position: "bottom-right",
    icons: {
        enabled: false
    }
};

document.addEventListener('DOMContentLoaded', function() {
    if (document.querySelector(".notices--success")) {
        new AWN().success('Baw się dobrze', options);
    }
});
