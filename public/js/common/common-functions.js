number_format = function (value, precision, dec_point, thousands_sep) {
    value = (value + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+value) ? 0 : +value,
        prec = !isFinite(+precision) ? 0 : Math.abs(precision),
        sep = (typeof thousands_sep === 'undefined') ? ' ' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? ',' : dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k).toFixed(prec);
        };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
        .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
};
Array.prototype.isEqual = function (array) {
    return this.every((e)=> array.includes(e)) && array.every((e)=> this.includes(e));
};
Array.prototype.containsAll = function (array) {
    return array.every(v => this.includes(v));
};