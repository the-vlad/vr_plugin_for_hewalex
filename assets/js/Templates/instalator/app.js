(function(t) {
    function e(e) {
        for (var a, O, s = e[0], P = e[1], r = e[2], c = 0, R = []; c < s.length; c++)
            O = s[c],
            Object.prototype.hasOwnProperty.call(n, O) && n[O] && R.push(n[O][0]),
                n[O] = 0;
        for (a in P)
            Object.prototype.hasOwnProperty.call(P, a) && (t[a] = P[a]);
        l && l(e);
        while (R.length)
            R.shift()();
        return i.push.apply(i, r || []),
            o()
    }
    function o() {
        for (var t, e = 0; e < i.length; e++) {
            for (var o = i[e], a = !0, s = 1; s < o.length; s++) {
                var P = o[s];
                0 !== n[P] && (a = !1)
            }
            a && (i.splice(e--, 1),
                t = O(O.s = o[0]))
        }
        return t
    }
    var a = {}
        , n = {
        app: 0
    }
        , i = [];
    function O(e) {
        if (a[e])
            return a[e].exports;
        var o = a[e] = {
            i: e,
            l: !1,
            exports: {}
        };
        return t[e].call(o.exports, o, o.exports, O),
            o.l = !0,
            o.exports
    }
    O.m = t,
        O.c = a,
        O.d = function(t, e, o) {
            O.o(t, e) || Object.defineProperty(t, e, {
                enumerable: !0,
                get: o
            })
        }
        ,
        O.r = function(t) {
            "undefined" !== typeof Symbol && Symbol.toStringTag && Object.defineProperty(t, Symbol.toStringTag, {
                value: "Module"
            }),
                Object.defineProperty(t, "__esModule", {
                    value: !0
                })
        }
        ,
        O.t = function(t, e) {
            if (1 & e && (t = O(t)),
            8 & e)
                return t;
            if (4 & e && "object" === typeof t && t && t.__esModule)
                return t;
            var o = Object.create(null);
            if (O.r(o),
                Object.defineProperty(o, "default", {
                    enumerable: !0,
                    value: t
                }),
            2 & e && "string" != typeof t)
                for (var a in t)
                    O.d(o, a, function(e) {
                        return t[e]
                    }
                        .bind(null, a));
            return o
        }
        ,
        O.n = function(t) {
            var e = t && t.__esModule ? function() {
                        return t["default"]
                    }
                    : function() {
                        return t
                    }
            ;
            return O.d(e, "a", e),
                e
        }
        ,
        O.o = function(t, e) {
            return Object.prototype.hasOwnProperty.call(t, e)
        }
        ,
        O.p = "/public/internal-frames/mounting-calculator/";
    var s = window["webpackJsonp"] = window["webpackJsonp"] || []
        , P = s.push.bind(s);
    s.push = e,
        s = s.slice();
    for (var r = 0; r < s.length; r++)
        e(s[r]);
    var l = P;
    i.push([0, "chunk-vendors"]),
        o()
}
)({
0: function(t, e, o) {
    t.exports = o("56d7")
},
"034f": function(t, e, o) {
    "use strict";
    o("64a9")
},
"13e5": function(t) {
    t.exports = JSON.parse('{"artykuly":"ARTYKUŁY","dachowka-opis":"Pomiaru należy dokonać mierząc dachówkę od zamka do jej końca.","dlugosc-haka":"Długość haka","dlugosc-profilu":"Długość profilu","dodaj-mocowanie":"Dodaj kolejne mocowanie","domyslny":"domyślny","drukuj":"Drukuj","generuj":"Wygeneruj zestawienie","grunt-info":"W PRZYPADKU TEGO TYPU MOCOWANIA ILOŚĆ PANELI MUSI BYĆ WIELOKROTNOŚCIĄ LICZBY 4","ilosc":"ILOŚĆ","ilosc-paneli":"ILOŚĆ PANELI","kat-15":"kąt 15°","kat-20":"kąt 20°","kat-30":"kąt 30°","liczba-paneli":"Podaj liczbę paneli","liczba-rzedow":"Podaj liczbę rzędów","liczba-sekcji":"Podaj liczbę sekcji","nachylenie-1":"Nachylenie panelu","nachylenie-2":"Nachylenie paneli","nr-kat":"NR. KAT","orientacja":"Orientacja panelu","panel-pionowo":"Panel pionowo","panel-poziomo":"Panel poziomo","pionowo":"pionowo","podwojnie-poziomo-info":"W PRZYPADKU TEGO TYPU MOCOWANIA ILOŚĆ PANELI MUSI BYĆ PARZYSTA","powierzchnia":"Powierzchnia","powrot":"Powrót","poziomo":"poziomo","rozstaw":"Rozstaw","rozstaw-mm":"Rozstaw krokwi (mm)","typ":"typ","usun":"usuń","w-rzedzie":"w rzędzie","wybierz":"wybierz","zamknij":"Zamknij","zapisz-pdf":"Zapisz do PDF","grunt-poziomo-info":"KONSTRUKCJA DWUPODPOROWA JEST STANDARDOWO CZTERORZĘDOWA. PROSZĘ PODAĆ LICZBĘ SEKCJI, CZYLI LICZBĘ GRUP NIEPOŁĄCZONYCH ZE SOBĄ KONSTRUKCJI","grunt-pionowo-info":"KONSTRUKCJA JEDNOPODPOROWA JEST STANDARDOWO DWURZĘDOWA. PROSZĘ PODAĆ LICZBĘ SEKCJI, CZYLI LICZBĘ GRUP NIEPOŁĄCZONYCH ZE SOBĄ KONSTRUKCJI","surface":{"grunt":"Grunt","plaski":"Dach płaski","skosny":"Dach pochyły"},"types":{"bitumiczne":"Pokrycie bitumiczne","blachodachowka":"Blachodachówka","dachowka":"Dachówka","dwupodporowa-poziomo":"Dwupodporowa poziomo","jednopodporowa-pionowo":"Jednopodporowa pionowo","podwojnie-poziom":"Podwójnie poziomo","pojedynczo-poziom":"Pojedynczo poziomo","pojedynczo-pion":"Pojedynczo pionowo","rabek":"Rąbek stojący","trapez":"Trapez"}}')
},
"4bef": function(t) {
    t.exports = JSON.parse('{"artykuly":"ARTICLES","bitumiczna":"bituminous","blachodachówka":"corrugated steel","dachowka-opis":"The measurement should be made by measuring the tile from its lock to its end","dachówka":"tile","dlugosc-haka":"Hook length","dlugosc-profilu":"Profile length","dodaj-mocowanie":"Add a bracket","domyslny":"default","drukuj":"Print","generuj":"Generate list","grunt-info":"WITH THIS MOUNTING TYPE, THE NUMBER OF PANELS MUST BE MULTIPLIER OF 4","ilosc":"COUNT","ilosc-paneli":"PANELS COUNT","kat-15":"15° angle","kat-20":"20° angle","kat-30":"30° angle","kąt 15°":"15° angle","kąt 20°":"20° angle","kąt 30°":"30° angle","liczba-paneli":"Give panels count","liczba-rzedow":"Give rows number","liczba-sekcji":"Give section count","nr-kat":"CAT. NO","orientacja":"Orientation","panel-pionowo":"Panel vertically","panel-poziomo":"Panel horizontally","pionowo":"vertically","płaska":"flat","podwojnie-poziomo-info":"WITH THIS MOUNTING TYPE, THE NUMBER OF PANELS MUST BE EVEN","powierzchnia":"Surface","powrot":"Return","poziomo":"horizontally","rąbek":"standing seam","rozstaw":"Spacing","rozstaw-mm":"Rafter spacing in mm","trapez":"trapezoidal","typ":"type","usun":"remove","w-rzedzie":"in a row","wybierz":"select","zamknij":"Close","zapisz-pdf":"Save as PDF","grunt-poziomo-info":"THE DOUBLE-SUPPORTED CONSTRUCTION IS STANDARD WITH A FOUR-ROW. PLEASE SPECIFY THE NUMBER OF SECTIONS, OR THE NUMBER OF GROUPS NOT CONNECTED WITH THE CONSTRUCTION","grunt-pionowo-info":"THE SINGLE SUPPORT CONSTRUCTION IS STANDARD WITH A DOUBLE ROW. PLEASE SPECIFY THE NUMBER OF SECTIONS, OR THE NUMBER OF GROUPS NOT CONNECTED WITH THE CONSTRUCTION","surface":{"grunt":"Ground","plaski":"Flat roof","skosny":"Sloped roof"},"types":{"bitumiczne":"Bituminous coverage","blachodachowka":"Corrugated steel","dachowka":"Tile","dwupodporowa-poziomo":"Double support horizontal","jednopodporowa-pionowo":"Single support vertical","podwojnie-poziom":"Double horizontal","pojedynczo-poziom":"Horizontal","pojedynczo-pion":"Vertical","rabek":"Standing seam","trapez":"Trapezoidal"},"products":{"PROFIL PV44 1VB – 996 (2 SZT)":"PROFILE PV 40X40 1VB – SET (2 PCS)","PROFIL PV44 1VR – 996 (2 SZT)":"PROFILE PV 40X40 1VR – SET (2 PCS)","PROFIL PV44 2VB – 996 (2 SZT)":"PROFILE PV 40X40 2VB – SET (2 PCS)","PROFIL PV44 2VR – 996 (2 SZT)":"PROFILE PV 40X40 2VR – SET (2 PCS)","PROFIL PV44 1HB – 1690 (2 SZT)":"PROFILE PV 40X40 1HB – SET (2 PCS)","PROFIL PV44 1HR – 1690 (2 SZT)":"PROFILE PV 40X40 1HR – SET (2 PCS)","DOCISK PV SKRAJNY 35 - KPL (4 SZT)":"PV EDGE HOLDER - SET (4 PCS)","DOCISK PV ŚRODKOWY 35 – KPL (2 SZT)":"PV CENTRAL HOLDER 35 – SET (2 PCS)","ŚRUBA 2GW M10-250 Z ADAPTEREM - KPL (2 SZT)":"DOUBLE THREADED SCREW 2GW M10-250 WITH ADAPTER - SET (2 PCS)","HAK DC430 - KPL (2 SZT)":"HOOK DC430 – SET (2 PCS)","HAK DC470 - KPL (2 SZT)":"HOOK DC470 – SET (2 PCS)","HAK DC500 - KPL (2 SZT)":"HOOK DC500 – SET (2 PCS)","HAK DC530 - KPL (2 SZT)":"HOOK DC530 – SET (2 PCS)","HAK DK430 - KPL (2 SZT)":"HOOK DK430 – SET (2 PCS)","HAK DB200 – KPL (2 SZT)":"HOOK DB200 – SET (2 PCS)","ZACISK RĄBEK – KPL (2 SZT)":"SEAM CLAMP – SET (2 PCS)","ZACISK RĄBEK PV - KPL (2 SZT)":"SEAM CLAMP PV – SET (2 PCS)","PROFIL TRAPEZ 300 – KPL (2 SZT)":"TRAPEZOIDAL PROFILE 300 – SET (2 PCS)","PROFIL TRAPEZ 400 – KPL (2 SZT)":"TRAPEZOIDAL PROFILE 400 – SET (2 PCS)","PODPORA PV V15":"SUPPORT PV V15","WZMOCNIENIE PV V15 – 996":"STRUT PV V15","PODPORA PV V20":"SUPPORT PV V20","WZMOCNIENIE PV V20 – 996":"STRUT PV V20","PODPORA PV V30":"SUPPORT PV V30","WZMOCNIENIE PV V30 – 996":"STRUT PV V30","PODPORA PV 1 H20 – 996":"SUPPORT PV 1 H20","PODPORA PV 1 H30 – 996":"SUPPORT PV 1 H30","PODPORA PV 2 H30 – 996":"SUPPORT PV 2 H30","WZMOCNIENIE PV 2 H30":"STRUT PV 2 H30","ŚRUBA 2GW M10-250":"DOUBLE THREADED SCREW 2GW M10-250","ŚRUBA 2GW M10-250 Z ADAPTEREM":"DOUBLE THREADED SCREW 2GW M10-250 WITH ADAPTER - SET (2 PCS)","WKRĘT DOCISKOWY M10 - KPL":"GRUB SCREW M10 - SET","ZESTAW PROFILI 40X40 BAZA 1":"PROFILE SET 40X40 BASE 1","ZESTAW MONTAŻOWY BAZA 2 35":"MOUNTING SET BASE 2 35","ZESTAW MONTAŻOWY ROZBUDOWA 2 35":"MOUNTING SET EXTENSION 2 35","ZESTAW MONTAŻOWY BAZA 1 35":"MOUNTING SET BASE 1 35","ZESTAW MONTAŻOWY POZIOMY 2 35":"MOUNTING SET HORIZONTAL 2 35","ŚRUBY DO UCHWYTU 2B":"SCREW OF BRACKET 2B","ŚRUBY DO UCHWYTU 1B":"SCREW OF BRACKET 1B","ŚRUBY DO UCHWYTU 2R":"SCREW OF BRACKET 2R","ZESTAW MONTAŻOWY RĄBEK BAZA 2":"MOUNTING KIT SEAM BASE 2","ZESTAW MONTAŻOWY RĄBEK BAZA 1":"MOUNTING KIT SEAM BASE 1","ZESTAW MONTAŻOWY RĄBEK ROZBUDOWA 2":"MOUNTING KIT SEAM BASE EXTENSION 2","ZESTAW MONTAŻOWY TRAPEZ BAZA 1":"MOUNTING KIT SEAM TRAPEZOIDAL BASE 1","ŚRUBA DWUGWINTOWA KPL DODATEK":"SET DOUBLE THREADED SCREW EXTENSION","HAK Z REGULACJĄ KPL DODATEK":"AJUSTABLE HOOK SET EXTENSION","RĄBEK KPL DODATEK":"SEAM SET EXTENSION","TRAPEZ KPL DODATEK":"TRAPEZOIDAL SET EXTENSION","ZASTRZAŁ KONSTRUKCJI POZIOMEJ ŁĄCZNIK":"STRUT OF HORIZONTAL KIT","KARTON 280X250X200 - PRZEPUSTNICA DN160":"CARTON 280X250X200 - THROTTLE DN160","PODPORA PRZEDNIA C80 4H-MG":"FRONT SUPPORT C80 4H-MG","PODPORA TYLNA C80 4H-MG":"REAR SUPPORT C80 4H-MG","PROFIL WZDŁUŻNY C80 4H-MG":"LONGITUDINAL PROFILE C80 4H-MG","PROFIL POPRZECZNY C80 4H-MG":"TRANSVERSE PROFILE C80 4H-MG","DOCISK PV ŚRODKOWY 35 - M6-MG KPL (6SZT)":"PV CENTRAL HOLDER 35 - M6-MG SET (6PCS)","DOCISK PV SKRAJNY 35 - M6-MG KPL (4SZT)":"PV EDGE HOLDER 35 - M6-MG SET (4PCS)","ZESTAW ŚRUB MONTAŻOWYCH 4H-MG":"SET OF SCREWS 4H-MG","PODPORA PRZEDNIA C80 2V-MG":"FRONT SUPPORT C80 2V-MG","PODPORA TYLNA C80 2V-MG":"REAR SUPPORT C80 2V-MG","WZMOCNIENIE PRZEDNIE C80 2V-MG":"FRONT STRUT C80 2V-MG","WZMOCNIENIE TYLNE C80 2V-MG":"REAR STRUT C80 2V-MG","PROFIL POPRZECZNY C80 2V-MG":"TRANSVERSE PROFILE C80 2V-MG","ŁĄCZNIK PODPORY C80 2V-MG":"CONNECTOR OF SUPPORT C80 2V-MG","PROFIL SKRAJNY C80 2V-MG":"EDGE PROFILE C80 2V-MG","PROFIL WZDŁUŻNY C80 2V-MG":"LONGITUDINAL PROFILE C80 2V-MG","DOCISK PV ŚRODKOWY 35 - M6-MG KPL (4SZT)":"PV CENTRAL HOLDER 35 - M6-MG SET (4PCS)","ZESTAW ŚRUB MONTAŻOWYCH 2V-MG":"SET OF SCREWS 2V-MG"}}')
},
"56d7": function(t, e, o) {
    "use strict";
    o.r(e);
    var a = o("2b0e")
        , n = function() {
        var t = this
            , e = t.$createElement
            , o = t._self._c || e;
        return o("v-app", [o("v-main", [o("Calculator", {
            ref: "calculator",
            attrs: {
                showShopButton: t.showShopButton
            }
        })], 1)], 1)
    }
        , i = []
        , O = function() {
        var t = this
            , e = t.$createElement
            , o = t._self._c || e;
        return o("v-container", {
            ref: "stepper",
            staticClass: "ma-0",
            attrs: {
                "text-left": "",
                wrap: ""
            }
        }, [o("v-select", {
            staticClass: "my-3 panel-picker-select",
            attrs: {
                items: t.manufacturers,
                label: "Producent panelu",
                dense: "",
                disabled: t.kinds.length > 0,
                "hide-details": "",
                attach: ""
            },
            model: {
                value: t.manufacturer,
                callback: function(e) {
                    t.manufacturer = e
                },
                expression: "manufacturer"
            }
        }), t.manufacturer ? t._e() : o("v-alert", {
            attrs: {
                dense: "",
                outlined: "",
                type: "info"
            }
        }, [t._v("Z powyższej listy wybierz producenta panelu.")]), o("v-stepper", {
            staticClass: "elevation-0",
            model: {
                value: t.step,
                callback: function(e) {
                    t.step = e
                },
                expression: "step"
            }
        }, [o("v-stepper-items", [o("v-stepper-content", {
            ref: "step1",
            staticClass: "pa-0",
            attrs: {
                step: "1"
            }
        }, [t._l(t.kinds, (function(e, a) {
                return o("v-row", {
                    key: a
                }, [o("v-col", [o("v-container", [o("div", {
                    staticClass: "headline text-left mb-2 ml-n3 d-flex align-center"
                }, [t._v("\n                " + t._s(a + 1) + ".\n                " + t._s(t.mountingBreadcrumbs(e)) + "\n                "), o("v-btn", {
                    directives: [{
                        name: "show",
                        rawName: "v-show",
                        value: t.$vuetify.breakpoint.smAndDown,
                        expression: "$vuetify.breakpoint.smAndDown"
                    }],
                    staticClass: "ma-2",
                    attrs: {
                        tile: "",
                        large: "",
                        color: "red",
                        icon: ""
                    },
                    on: {
                        click: function(e) {
                            return t.remove(a)
                        }
                    }
                }, [o("v-icon", [t._v("mdi-delete-outline")])], 1)], 1), o("v-row", [o("v-col", [o("v-row", {
                    staticClass: "mb-4",
                    attrs: {
                        align: "center"
                    }
                }, [o("v-avatar", {
                    attrs: {
                        color: "#2196f3",
                        size: "30"
                    }
                }, [o("span", {
                    staticClass: "white--text subtitle-1"
                }, [t._v("1")])]), o("strong", {
                    staticClass: "ml-3 subtitle-2"
                }, [t._v("\n                      " + t._s("Grunt" === e.mounting.group ? t.$t("liczba-sekcji") : t.$t("liczba-rzedow")) + ".\n                    ")])], 1), o("v-row", [o("v-col", {
                    attrs: {
                        sm: "12",
                        md: "3"
                    }
                }, [o("clickable-input", {
                    staticClass: "ml-7 mb-4",
                    model: {
                        value: e.rowsCount,
                        callback: function(o) {
                            t.$set(e, "rowsCount", t._n(o))
                        },
                        expression: "kind.rowsCount"
                    }
                })], 1), o("v-col", {
                    attrs: {
                        sm: "12",
                        md: "9"
                    }
                }, ["Grunt" === e.mounting.group ? o("v-alert", {
                    staticClass: "mb-4",
                    staticStyle: {
                        float: "left"
                    },
                    attrs: {
                        border: "left",
                        "colored-border": "",
                        type: "info"
                    }
                }, [t._v("\n                        " + t._s(t.$t("grunt-" + e.mounting.orientation + "-info")) + "\n                      ")]) : t._e()], 1)], 1), o("v-row", {
                    staticClass: "mb-4",
                    attrs: {
                        align: "center"
                    }
                }, [o("v-avatar", {
                    attrs: {
                        color: "#2196f3",
                        size: "30"
                    }
                }, [o("span", {
                    staticClass: "white--text subtitle-1"
                }, [t._v("2")])]), o("strong", {
                    staticClass: "ml-3 subtitle-2"
                }, [t._v("\n                      " + t._s(t.$t("liczba-paneli")) + t._s(t.showRowInfo(e["mounting"]) ? " " + t.$t("w-rzedzie") : "") + ".\n                    ")])], 1), t._l(e.rowsCount, (function(n) {
                        return o("v-row", {
                            key: n
                        }, [o("v-col", {
                            attrs: {
                                sm: "12",
                                md: "3"
                            }
                        }, [o("clickable-input", {
                            staticClass: "ml-7 mb-4",
                            attrs: {
                                value: e.rows[n - 1] || 0,
                                step: t.getKindStep(e)
                            },
                            on: {
                                input: function(e) {
                                    return t.updateRow(a, n, e)
                                }
                            }
                        })], 1), o("v-col", {
                            attrs: {
                                sm: "12",
                                md: "9"
                            }
                        }, ["KONSTRUKCJA 2 POZIOMO" === e.mounting.name ? o("v-alert", {
                            staticClass: "mb-4",
                            attrs: {
                                border: "left",
                                "colored-border": "",
                                type: e.rows[n - 1] % 2 ? "error" : "info"
                            }
                        }, [t._v(t._s(t.$t("podwojnie-poziomo-info")) + ".")]) : t._e(), "KONSTRUKCJA DWUPODPOROWA POZIOMO 30°" === e.mounting.name || "KONSTRUKCJA JEDNOPODPOROWA PIONOWO 30°" === e.mounting.name ? o("v-alert", {
                            staticClass: "mb-4",
                            attrs: {
                                border: "left",
                                "colored-border": "",
                                type: e.rows[n - 1] % 4 ? "error" : "info"
                            }
                        }, [t._v(t._s(t.$t("grunt-info")) + ".")]) : t._e()], 1)], 1)
                    }
                ))], 2), o("v-col", {
                    staticClass: "fill-height justify-center",
                    attrs: {
                        cols: "5"
                    }
                }, [o("v-img", {
                    attrs: {
                        src: e["mounting"].image,
                        contain: "",
                        "max-height": "325"
                    }
                }, [o("v-row", {
                    staticClass: "lightbox white--text pa-2 fill-height",
                    attrs: {
                        align: "end"
                    }
                }, [o("v-col", {
                    staticClass: "d-flex justify-center"
                }, [o("v-btn", {
                    directives: [{
                        name: "show",
                        rawName: "v-show",
                        value: t.$vuetify.breakpoint.mdAndUp,
                        expression: "$vuetify.breakpoint.mdAndUp"
                    }],
                    staticClass: "ma-0 pa-0 elevation-0 text-lowercase red--text",
                    staticStyle: {
                        "background-color": "rgba(255, 255, 255, 0.5) !important"
                    },
                    attrs: {
                        block: "",
                        color: "white"
                    },
                    on: {
                        click: function(e) {
                            return t.remove(a)
                        }
                    }
                }, [o("v-icon", {
                    attrs: {
                        color: "red"
                    }
                }, [t._v("mdi-delete-outline")]), t._v("\n                          " + t._s(t.$t("usun")) + "\n                        ")], 1)], 1)], 1)], 1)], 1)], 1)], 1)], 1)], 1)
            }
        )), o("div", {
            staticClass: "mb-6"
        }, [o("add-mounting-menu", {
            attrs: {
                "hidden-ground": t.hiddenGround,
                haveSelections: 0 !== t.kinds.length
            },
            on: {
                selected: t.addMounting,
                clear: function(e) {
                    t.kinds = []
                }
            }
        })], 1), o("div", {
            staticClass: "text-center mb-4"
        }, [t.kinds.length ? o("v-btn", {
            staticClass: "white--text",
            attrs: {
                "x-large": "",
                color: "rgb(33, 150, 243)",
                disabled: 0 === t.modulesCount
            },
            on: {
                click: function(e) {
                    t.step = 2
                }
            }
        }, [t._v(t._s(t.$t("generuj")))]) : t._e()], 1)], 2), o("v-stepper-content", {
            staticClass: "pa-0",
            attrs: {
                step: "2"
            }
        }, [o("v-row", {
            staticClass: "text-left"
        }, [o("v-col", [o("v-divider", {
            staticClass: "mb-2"
        }), t._v("\n            " + t._s(t.$t("ilosc-paneli")) + ": " + t._s(t.modulesCount) + "\n            "), o("v-divider", {
            staticClass: "mt-2"
        })], 1)], 1), t.table.length ? o("v-row", {
            attrs: {
                id: "mountingCalculatorSummary"
            }
        }, [o("v-simple-table", {
            ref: "table",
            staticClass: "striped",
            staticStyle: {
                width: "100%"
            }
        }, [o("thead", [o("tr", [o("th", [t._v(t._s(t.$t("nr-kat")))]), o("th", [t._v(t._s(t.$t("artykuly")))]), o("th", {
            staticClass: "text-center"
        }, [t._v(t._s(t.$t("ilosc")))])])]), o("tbody", t._l(t.table, (function(e) {
                return o("tr", {
                    key: e.name
                }, [o("td", {
                    attrs: {
                        width: "90px"
                    }
                }, [t._v(t._s(e.code))]), o("td", [t._v(t._s(t.getItemName(e.name)))]), o("td", {
                    staticClass: "text-center",
                    attrs: {
                        width: "90px"
                    }
                }, [t._v(t._s(e.sum + ""))])])
            }
        )), 0)])], 1) : t._e(), o("v-row", [o("v-col", {
            staticClass: "mx-3 pb-0",
            attrs: {
                cols: "12"
            }
        }, [o("v-switch", {
            scopedSlots: t._u([{
                key: "label",
                fn: function() {
                    return [o("div", [t._v("\n                  Dodaj podkładki uziemiające:\n                  "), o("strong", {
                        staticClass: "primary--text"
                    }, [t._v(t._s(t.gasketSwitch ? "TAK" : "NIE"))])])]
                },
                proxy: !0
            }]),
            model: {
                value: t.gasketSwitch,
                callback: function(e) {
                    t.gasketSwitch = e
                },
                expression: "gasketSwitch"
            }
        })], 1), o("v-col", {
            staticClass: "mx-3 pb-0 pt-0",
            attrs: {
                cols: "12"
            }
        }, [o("v-switch", {
            staticClass: "mt-0",
            attrs: {
                disabled: t.disableBfSwitch
            },
            scopedSlots: t._u([{
                key: "label",
                fn: function() {
                    return [o("div", [t._v("\n                  Mocowania dla paneli z czarną ramą:\n                  "), o("strong", {
                        staticClass: "primary--text"
                    }, [t._v(t._s(t.bfSwitch ? "TAK" : "NIE"))])])]
                },
                proxy: !0
            }]),
            model: {
                value: t.bfSwitch,
                callback: function(e) {
                    t.bfSwitch = e
                },
                expression: "bfSwitch"
            }
        })], 1), t.panelsPower.length > 0 ? o("v-col", {
            staticClass: "mx-3 pt-0",
            attrs: {
                cols: "12"
            }
        }, [o("p", {
            staticClass: "mb-0"
        }, [o("v-label", [t._v("Moc panelu:")])], 1), o("v-btn-toggle", {
            attrs: {
                mandatory: "",
                color: "blue darken-4"
            },
            model: {
                value: t.panelPower,
                callback: function(e) {
                    t.panelPower = e
                },
                expression: "panelPower"
            }
        }, t._l(t.panelsPower, (function(e) {
                return o("v-btn", {
                    key: e.value,
                    attrs: {
                        value: e.value
                    }
                }, [t._v(t._s(e.name))])
            }
        )), 1)], 1) : t._e()], 1), o("div", {
            staticClass: "d-flex my-4"
        }, [o("v-btn", {
            attrs: {
                "x-large": "",
                color: "rgb(33, 150, 243)",
                outlined: ""
            },
            on: {
                click: function(e) {
                    t.step = 1
                }
            }
        }, [o("v-icon", [t._v("mdi-chevron-left")]), t._v("\n            " + t._s(t.$t("powrot")) + "\n          ")], 1), o("div", {
            staticClass: "flex-grow-1"
        }), o("v-btn", {
            staticClass: "mr-4",
            attrs: {
                outlined: "",
                "x-large": "",
                color: "rgb(33, 150, 243)"
            },
            on: {
                click: function(e) {
                    return t.pdf()
                }
            }
        }, [o("v-icon", [t._v("mdi-file-pdf")]), t._v("\n            " + t._s(t.$t("zapisz-pdf")) + "\n          ")], 1), o("v-btn", {
            attrs: {
                outlined: "",
                "x-large": "",
                color: "rgb(33, 150, 243)"
            },
            on: {
                click: function(e) {
                    return t.print()
                }
            }
        }, [o("v-icon", [t._v("mdi-printer")]), t._v("\n            " + t._s(t.$t("drukuj")) + "\n          ")], 1), t.showShopButton ? o("v-btn", {
            staticClass: "white--text ml-4",
            attrs: {
                "x-large": "",
                color: "rgb(33, 150, 243)"
            },
            on: {
                click: function(e) {
                    return t.send()
                }
            }
        }, [o("v-icon", [t._v("mdi-cart-arrow-down")]), t._v("Wyślij do sklepu\n          ")], 1) : t._e()], 1)], 1)], 1)], 1)], 1)
    }
        , s = []
        , P = o("bc29")
        , r = o("7b48")
        , l = function() {
        var t = this
            , e = t.$createElement
            , o = t._self._c || e;
        return o("div", {
            staticClass: "text-center"
        }, [o("div", [o("v-expand-transition", [o("div", {
            directives: [{
                name: "show",
                rawName: "v-show",
                value: t.show || !t.haveSelections,
                expression: "show || !haveSelections"
            }]
        }, [o("v-tabs", {
            ref: "tabs",
            attrs: {
                "background-color": "transparent",
                color: "basil"
            },
            model: {
                value: t.tab,
                callback: function(e) {
                    t.tab = e
                },
                expression: "tab"
            }
        }, t._l(t.filteredItems, (function(e) {
                return o("v-tab", {
                    key: e.group,
                    staticClass: "ma-0 grey lighten-4"
                }, [t._v(t._s(t.$t(e.title)))])
            }
        )), 1), o("v-tabs-items", {
            staticClass: "mb-6 px-2",
            model: {
                value: t.tab,
                callback: function(e) {
                    t.tab = e
                },
                expression: "tab"
            }
        }, t._l(t.items, (function(e) {
                return o("v-tab-item", {
                    key: e.group,
                    staticClass: "mb-2"
                }, [o("v-row", t._l(e.items, (function(a) {
                        return o("v-col", {
                            key: a.name,
                            attrs: {
                                md: "4",
                                sm: "6"
                            }
                        }, [o("v-card", {
                            staticClass: "mx-auto elevation-1 mt-4 py-2",
                            attrs: {
                                flat: ""
                            },
                            on: {
                                click: function(e) {
                                    return t.selectKind(a.name)
                                }
                            }
                        }, [o("v-card-text", {
                            staticClass: "justify-center"
                        }, [o("v-img", {
                            staticClass: "mx-auto my-2",
                            attrs: {
                                "aspect-ratio": 16 / 9,
                                src: a.image,
                                width: "300"
                            }
                        }), t._v("\n                    " + t._s(t.$t(a.title)) + "\n                  ")], 1), o("v-overlay", {
                            attrs: {
                                absolute: "",
                                color: "white",
                                opacity: ".9",
                                value: t.kindName === a.name
                            }
                        }, ["Dachówka" !== a.name && "Blachodachówka" !== a.name && a.options ? [o("v-card-text", {
                            staticClass: "px-0 py-2 grey--text text--darken-3 ml-n3",
                            staticStyle: {
                                "min-width": "140px"
                            }
                        }, [t._v("\n                        " + t._s(t.$t("Powierzchnia płaska" === e.group || "Grunt" === e.group || "Trapez" === a.name ? a.header : "orientacja")) + ":\n                      ")]), o("v-list", {
                            staticClass: "white-text",
                            attrs: {
                                dense: "",
                                color: "transparent"
                            }
                        }, t._l(a.options, (function(n, i) {
                                return o("v-list-item", {
                                    key: i
                                }, [o("v-list-item-content", {
                                    staticClass: "py-1"
                                }, [o("v-list-item-title", [o("v-btn", {
                                    staticStyle: {
                                        "background-color": "rgba(0, 0, 0, 0.54)"
                                    },
                                    attrs: {
                                        text: "",
                                        small: ""
                                    },
                                    on: {
                                        click: function(o) {
                                            return t.select(Object.assign({}, n.value, {
                                                group: e.group
                                            }), a.image, o)
                                        }
                                    }
                                }, [t._v(t._s(t.$t(n.title)))])], 1)], 1)], 1)
                            }
                        )), 1)] : "Dachówka" === a.name ? [o("v-card-text", {
                            staticClass: "px-0 py-2 grey--text text--darken-3 ml-n3"
                        }, [t._v(t._s(t.$t("orientacja")) + ":")]), o("v-row", [o("v-btn-toggle", {
                            staticStyle: {
                                "background-color": "rgba(0, 0, 0, 0.54)"
                            },
                            attrs: {
                                mandatory: ""
                            },
                            model: {
                                value: t.orientation,
                                callback: function(e) {
                                    t.orientation = e
                                },
                                expression: "orientation"
                            }
                        }, [o("v-btn", {
                            attrs: {
                                text: "",
                                small: "",
                                value: "pionowo"
                            },
                            on: {
                                click: function(t) {
                                    t.stopPropagation()
                                }
                            }
                        }, [t._v("\n                            " + t._s(t.$t("pionowo")) + "\n                          ")]), o("v-btn", {
                            attrs: {
                                text: "",
                                small: "",
                                value: "poziomo"
                            },
                            on: {
                                click: function(t) {
                                    t.stopPropagation()
                                }
                            }
                        }, [t._v("\n                            " + t._s(t.$t("poziomo")) + "\n                          ")])], 1)], 1), o("v-card-text", {
                            staticClass: "px-0 py-2 grey--text text--darken-3 ml-n3"
                        }, [t._v("\n                        " + t._s(t.$t("dlugosc-haka")) + ":\n                        "), o("v-dialog", {
                            attrs: {
                                width: "500"
                            },
                            scopedSlots: t._u([{
                                key: "activator",
                                fn: function(e) {
                                    var a = e.on;
                                    return [o("v-btn", t._g({
                                        attrs: {
                                            color: "blue lighten-2",
                                            icon: ""
                                        }
                                    }, a), [o("v-icon", [t._v("mdi-information")])], 1)]
                                }
                            }], null, !0),
                            model: {
                                value: t.dialog,
                                callback: function(e) {
                                    t.dialog = e
                                },
                                expression: "dialog"
                            }
                        }, [o("v-card", [o("v-card-text", {
                            staticClass: "text-center pt-2 subtitle-1"
                        }, [o("v-img", {
                            staticClass: "my-2 mx-auto",
                            attrs: {
                                src: instalator_template_rest.zh_url + "public/img/pv/wymiar.png",
                                "max-width": "300"
                            }
                        }), t._v("\n                              " + t._s(t.$t("dachowka-opis")) + "\n                            ")], 1), o("v-divider"), o("v-card-actions", [o("div", {
                            staticClass: "flex-grow-1"
                        }), o("v-btn", {
                            attrs: {
                                color: "primary",
                                text: ""
                            },
                            on: {
                                click: function(e) {
                                    t.dialog = !1
                                }
                            }
                        }, [t._v(t._s(t.$t("zamknij")))])], 1)], 1)], 1)], 1), o("v-row", [o("v-btn-toggle", {
                            staticStyle: {
                                "background-color": "rgba(0, 0, 0, 0.54)"
                            },
                            attrs: {
                                mandatory: ""
                            },
                            model: {
                                value: t.size,
                                callback: function(e) {
                                    t.size = e
                                },
                                expression: "size"
                            }
                        }, t._l([430, 470, 500, 530], (function(e) {
                                return o("v-btn", {
                                    key: e,
                                    attrs: {
                                        text: "",
                                        small: "",
                                        value: e
                                    },
                                    on: {
                                        click: function(t) {
                                            t.stopPropagation()
                                        }
                                    }
                                }, [t._v(t._s(e))])
                            }
                        )), 1)], 1), o("div", {
                            staticClass: "d-flex mt-6 ml-n3"
                        }, [o("v-btn", {
                            staticStyle: {
                                "background-color": "rgba(0, 0, 0, 0.54)"
                            },
                            attrs: {
                                text: "",
                                small: "",
                                disabled: !t.orientation || !t.size
                            },
                            on: {
                                click: function(o) {
                                    return t.select({
                                        name: a.name,
                                        group: e.group
                                    }, a.image, o)
                                }
                            }
                        }, [t._v(t._s(t.$t("wybierz")))])], 1)] : "Blachodachówka" === a.name ? [o("v-card-text", {
                            staticClass: "px-0 py-2 grey--text text--darken-3 ml-n3"
                        }, [t._v(t._s(t.$t("orientacja")) + ":")]), o("v-row", [o("v-btn-toggle", {
                            staticStyle: {
                                "background-color": "rgba(0, 0, 0, 0.54)"
                            },
                            attrs: {
                                mandatory: ""
                            },
                            model: {
                                value: t.orientation,
                                callback: function(e) {
                                    t.orientation = e
                                },
                                expression: "orientation"
                            }
                        }, [o("v-btn", {
                            attrs: {
                                text: "",
                                small: "",
                                value: "pionowo"
                            },
                            on: {
                                click: function(t) {
                                    t.stopPropagation()
                                }
                            }
                        }, [t._v("\n                            " + t._s(t.$t("pionowo")) + "\n                          ")]), o("v-btn", {
                            attrs: {
                                text: "",
                                small: "",
                                value: "poziomo"
                            },
                            on: {
                                click: function(t) {
                                    t.stopPropagation()
                                }
                            }
                        }, [t._v("\n                            " + t._s(t.$t("poziomo")) + "\n                          ")])], 1)], 1), o("v-card-text", {
                            staticClass: "px-0 py-2 grey--text text--darken-3 ml-n3"
                        }, [t._v(t._s(t.$t("rozstaw-mm")) + ":")]), o("v-row", [o("clickable-input", {
                            attrs: {
                                dark: "",
                                step: 10
                            },
                            model: {
                                value: t.size,
                                callback: function(e) {
                                    t.size = e
                                },
                                expression: "size"
                            }
                        })], 1), o("div", {
                            staticClass: "d-flex mt-6 ml-n3"
                        }, [o("v-btn", {
                            staticStyle: {
                                "background-color": "rgba(0, 0, 0, 0.54)"
                            },
                            attrs: {
                                text: "",
                                small: "",
                                disabled: !t.orientation || !t.size
                            },
                            on: {
                                click: function(o) {
                                    return t.select({
                                        name: a.name,
                                        group: e.group
                                    }, a.image, o)
                                }
                            }
                        }, [t._v(t._s(t.$t("wybierz")))])], 1)] : t._e()], 2)], 1)], 1)
                    }
                )), 1)], 1)
            }
        )), 1)], 1)])], 1), o("div", {
            staticClass: "d-flex"
        }, [o("v-btn", {
            directives: [{
                name: "show",
                rawName: "v-show",
                value: t.haveSelections,
                expression: "haveSelections"
            }],
            attrs: {
                color: "rgb(33, 150, 243)",
                outlined: ""
            },
            on: {
                click: function(e) {
                    return t.$emit("clear")
                }
            }
        }, [o("v-icon", [t._v("mdi-chevron-left")]), t._v("\n      " + t._s(t.$t("powrot")) + "\n    ")], 1), o("div", {
            staticClass: "flex-grow-1"
        }), o("v-btn", {
            directives: [{
                name: "show",
                rawName: "v-show",
                value: t.haveSelections,
                expression: "haveSelections"
            }],
            attrs: {
                color: "rgb(33, 150, 243)",
                dark: ""
            },
            on: {
                click: function(e) {
                    return t.showHandle()
                }
            }
        }, [t._v(t._s(t.$t("dodaj-mocowanie")))])], 1)])
    }
        , c = []
        , R = function() {
        var t = this
            , e = t.$createElement
            , o = t._self._c || e;
        return o("v-text-field", {
            staticClass: "spin-off clickable-input centered-input",
            attrs: {
                dark: t.dark,
                step: t.step,
                "hide-details": "",
                "single-line": "",
                min: "0",
                type: "number",
                "append-icon": "mdi-plus",
                "prepend-inner-icon": "mdi-minus"
            },
            on: {
                "click:append": function(e) {
                    return t.inc()
                },
                "click:prepend-inner": function(e) {
                    return t.dec()
                }
            },
            model: {
                value: t.localValue,
                callback: function(e) {
                    t.localValue = t._n(e)
                },
                expression: "localValue"
            }
        })
    }
        , S = []
        , u = {
        props: {
            dark: Boolean,
            step: {
                type: Number,
                default: 1
            },
            value: Number
        },
        computed: {
            localValue: {
                get() {
                    return this.value
                },
                set(t) {
                    this.$emit("input", t)
                }
            }
        },
        methods: {
            dec() {
                this.localValue > 0 && (this.localValue -= this.step)
            },
            inc() {
                this.localValue += this.step
            }
        }
    }
        , A = u
        , T = o("2877")
        , p = o("6544")
        , E = o.n(p)
        , d = o("8654")
        , C = Object(T["a"])(A, R, S, !1, null, null, null)
        , I = C.exports;
    E()(C, {
        VTextField: d["a"]
    });
    var m = {
        props: {
            haveSelections: Boolean,
            hiddenGround: Boolean
        },
        data: ()=>({
            dialog: !1,
            items: [{
                group: "Dach skośny",
                title: "surface.skosny",
                items: [{
                    name: "Dachówka",
                    title: "types.dachowka",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-08.jpg",
                    options: []
                }, {
                    name: "Blachodachówka",
                    title: "types.blachodachowka",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-07.jpg",
                    options: [{
                        name: "Panel pionowo",
                        title: "pionowo",
                        value: {
                            name: "ŚRUBA",
                            orientation: "pionowo",
                            surface: "balchodachówka"
                        }
                    }, {
                        name: "Panel poziomo",
                        title: "poziomo",
                        value: {
                            name: "ŚRUBA POZIOMO",
                            orientation: "poziomo",
                            surface: "blachodachówka"
                        }
                    }]
                }, {
                    name: "Pokrycie bitumiczne",
                    title: "types.bitumiczne",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-12.jpg",
                    options: [{
                        name: "Panel pionowo",
                        title: "pionowo",
                        value: {
                            name: "BITUM",
                            orientation: "pionowo",
                            surface: "bitumiczna"
                        }
                    }, {
                        name: "Panel poziomo",
                        title: "poziomo",
                        value: {
                            name: "BITUM POZIOMO",
                            orientation: "poziomo",
                            surface: "bitumiczna"
                        }
                    }]
                }, {
                    name: "Rąbek stojący",
                    title: "types.rabek",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-09.jpg",
                    options: [{
                        name: "Panel pionowo",
                        title: "pionowo",
                        value: {
                            name: "RĄBEK",
                            orientation: "pionowo",
                            surface: "rąbek"
                        }
                    }, {
                        name: "Panel poziomo",
                        title: "poziomo",
                        value: {
                            name: "RĄBEK POZIOMO",
                            orientation: "poziomo",
                            surface: "rąbek"
                        }
                    }]
                }, {
                    name: "Trapez",
                    title: "types.trapez",
                    header: "dlugosc-profilu",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-10.jpg",
                    options: [{
                        name: "300",
                        title: "300",
                        value: {
                            name: "TRAPEZ 300",
                            orientation: "pionowo",
                            surface: "trapez"
                        }
                    }, {
                        name: "400",
                        title: "400",
                        value: {
                            name: "TRAPEZ 400",
                            orientation: "pionowo",
                            surface: "trapez"
                        }
                    }]
                }]
            }, {
                group: "Powierzchnia płaska",
                title: "surface.plaski",
                items: [{
                    name: "Pojedynczo poziomo",
                    title: "types.pojedynczo-poziom",
                    header: "nachylenie-1",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-01.jpg",
                    options: [{
                        name: "kąt 30°",
                        title: "kat-30",
                        value: {
                            name: "KONSTRUKCJA 1 POZIOMO 30°",
                            orientation: "poziomo",
                            surface: "płaska",
                            type: "kąt 30°"
                        }
                    }, {
                        name: "kąt 20°",
                        title: "kat-20",
                        value: {
                            name: "KONSTRUKCJA 1 POZIOMO 20°",
                            orientation: "poziomo",
                            surface: "płaska",
                            type: "kąt 20°"
                        }
                    }, {
                        name: "kąt 15°",
                        title: "kat-15",
                        value: {
                            name: "KONSTRUKCJA 1 POZIOMO 15°",
                            orientation: "poziomo",
                            surface: "płaska",
                            type: "kąt 15°"
                        }
                    }]
                }, {
                    name: "Pojedynczo pionowo",
                    title: "types.pojedynczo-pion",
                    header: "nachylenie-2",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-03.jpg",
                    options: [{
                        name: "kąt 30°",
                        title: "kat-30",
                        value: {
                            name: "KONSTRUKCJA PIONOWO 30°",
                            orientation: "pionowo",
                            surface: "płaska",
                            type: "kąt 30°"
                        }
                    }, {
                        name: "kąt 20°",
                        title: "kat-20",
                        value: {
                            name: "KONSTRUKCJA PIONOWO 20°",
                            orientation: "pionowo",
                            surface: "płaska",
                            type: "kąt 20°"
                        }
                    }, {
                        name: "kąt 15°",
                        title: "kat-15",
                        value: {
                            name: "KONSTRUKCJA PIONOWO 15°",
                            orientation: "pionowo",
                            surface: "płaska",
                            type: "kąt 15°"
                        }
                    }]
                }, {
                    name: "Podwójnie poziomo",
                    title: "types.podwojnie-poziom",
                    header: "nachylenie-2",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-05.jpg",
                    options: [{
                        name: "kąt 30°",
                        title: "kat-30",
                        value: {
                            name: "KONSTRUKCJA 2 POZIOMO",
                            orientation: "poziomo",
                            double: !0,
                            surface: "płaska"
                        }
                    }]
                }]
            }, {
                group: "Grunt",
                title: "surface.grunt",
                items: [{
                    name: "Dwupodporowa poziomo",
                    title: "types.dwupodporowa-poziomo",
                    header: "nachylenie-2",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-14.jpg",
                    options: [{
                        name: "kąt 30°",
                        title: "kat-30",
                        value: {
                            name: "KONSTRUKCJA DWUPODPOROWA POZIOMO 30°",
                            orientation: "poziomo",
                            surface: "grunt",
                            type: "kąt 30°"
                        }
                    }]
                }, {
                    name: "Jednopodporowa pionowo",
                    title: "types.jednopodporowa-pionowo",
                    header: "nachylenie-2",
                    image: window.zh_url + "public/img/pv/produkty/systemy/mocowanie-13.jpg",
                    options: [{
                        name: "kąt 30°",
                        title: "kat-30",
                        value: {
                            name: "KONSTRUKCJA JEDNOPODPOROWA PIONOWO 30°",
                            orientation: "pionowo",
                            surface: "grunt",
                            type: "kąt 30°"
                        }
                    }]
                }]
            }],
            kindName: "",
            orientation: "",
            show: !1,
            size: "",
            tab: 0
        }),
        computed: {
            filteredItems() {
                return this.hiddenGround ? this.items.filter(t=>"Grunt" !== t.group) : this.items
            }
        },
        methods: {
            dismiss() {
                this.orientation = "",
                    this.size = "",
                    this.kindName = "",
                    this.show = !1
            },
            selectKind(t) {
                t !== this.kindName && (this.orientation = "",
                    this.size = "Blachodachówka" === t ? 700 : "",
                    this.kindName = t)
            },
            select(t, e, o) {
                o.stopPropagation();
                let a = {
                    ...t,
                    image: e
                };
                if ("Dachówka" === a.name)
                    switch (this.orientation) {
                        case "pionowo":
                            a = {
                                group: a.group,
                                name: "DACHÓWKA " + this.size,
                                orientation: "pionowo",
                                surface: "dachówka",
                                type: "" + this.size,
                                image: e
                            };
                            break;
                        case "poziomo":
                            a = {
                                group: a.group,
                                name: `DACHÓWKA ${this.size} POZIOMO`,
                                orientation: "poziomo",
                                surface: "dachówka",
                                type: "" + this.size,
                                image: e
                            };
                            break
                    }
                "Blachodachówka" === a.name && (a.orientation = this.orientation,
                    a.surface = "blachodachówka",
                    a.name = "ŚRUBA" + ("poziomo" === this.orientation ? " POZIOMO" : ""),
                    a.size = this.size),
                    this.$emit("selected", a),
                    this.dismiss()
            },
            showHandle() {
                this.show = !0,
                    setTimeout(()=>{
                            this.$vuetify.goTo(this.$refs.tabs)
                        }
                        , 50)
            }
        },
        components: {
            ClickableInput: I
        }
    }
        , K = m
        , V = o("8336")
        , Z = o("a609")
        , N = o("b0af")
        , D = o("99d9")
        , L = o("62ad")
        , h = o("169a")
        , k = o("ce7e")
        , w = o("0789")
        , g = o("132d")
        , f = o("adda")
        , v = o("8860")
        , M = o("da13")
        , b = o("5d23")
        , B = o("a797")
        , W = o("0fd9")
        , y = o("71a3")
        , U = o("c671")
        , Y = o("fe57")
        , H = o("aac8")
        , z = Object(T["a"])(K, l, c, !1, null, null, null)
        , F = z.exports;
    E()(z, {
        VBtn: V["a"],
        VBtnToggle: Z["a"],
        VCard: N["a"],
        VCardActions: D["a"],
        VCardText: D["b"],
        VCol: L["a"],
        VDialog: h["a"],
        VDivider: k["a"],
        VExpandTransition: w["a"],
        VIcon: g["a"],
        VImg: f["a"],
        VList: v["a"],
        VListItem: M["a"],
        VListItemContent: b["a"],
        VListItemTitle: b["b"],
        VOverlay: B["a"],
        VRow: W["a"],
        VTab: y["a"],
        VTabItem: U["a"],
        VTabs: Y["a"],
        VTabsItems: H["a"]
    });
    var G = {
        props: {
            showShopButton: {
                type: Boolean,
                default: !1
            }
        },
        data: ()=>({
            bfSwitch: !0,
            gasketSwitch: !1,
            halfProducts: P,
            kinds: [],
            kindsCount: 1,
            manufacturer: null,
            manufacturers: ["Ja Solar", "Jinko", "Risen"],
            mounting: "",
            panelPower: "370-385",
            step: 0,
            replacementsFor370: {
                "52.02.09": {
                    sku: "52.02.14",
                    title: "PODPORA PV 1 H20 – 1052"
                },
                "52.02.10": {
                    sku: "52.02.15",
                    title: "PODPORA PV 1 H30 – 1052"
                },
                "52.02.11": {
                    sku: "52.02.16",
                    title: "PODPORA PV 2 H30 – 1052"
                },
                "52.02.13": {
                    sku: "52.02.12",
                    title: "PODPORA PV 1 H15 – 1052"
                },
                "52.04.04": {
                    sku: "52.04.09",
                    title: "WZMOCNIENIE PV V15 – 1052"
                },
                "52.04.05": {
                    sku: "52.04.10",
                    title: "WZMOCNIENIE PV V20 – 1052"
                },
                "52.04.06": {
                    sku: "52.04.11",
                    title: "WZMOCNIENIE PV V30 – 1052"
                },
                "52.06.07": {
                    sku: "52.06.13",
                    title: "PROFIL PV44 1VB – 1052 (2 SZT)"
                },
                "52.06.08": {
                    sku: "52.06.14",
                    title: "PROFIL PV44 1VR – 1052 (2 SZT)"
                },
                "52.06.09": {
                    sku: "52.06.15",
                    title: "PROFIL PV44 2VB – 1052 (2 SZT)"
                },
                "52.06.10": {
                    sku: "52.06.16",
                    title: "PROFIL PV44 2VR – 1052 (2 SZT)"
                },
                "52.06.11": {
                    sku: "52.06.17",
                    title: "PROFIL PV44 1HB – 1776 (2 SZT)"
                },
                "52.06.12": {
                    sku: "52.06.18",
                    title: "PROFIL PV44 1HR – 1776 (2 SZT)"
                },
                "52.08.03": {
                    sku: "52.08.19",
                    title: "PROFIL WZDŁUŻNY C80 4H-MG – 1052"
                },
                "52.08.04": {
                    sku: "52.08.20",
                    title: "PROFIL POPRZECZNY C80 4H-MG – 1052"
                },
                "52.08.12": {
                    sku: "52.08.18",
                    title: "PROFIL WZDŁUŻNY C80 2V-MG – 1052"
                }
            },
            replacementsFor455: {
                "52.02.06": {
                    sku: "52.02.17",
                    title: "PODPORA PV V15 - 2120"
                },
                "52.02.07": {
                    sku: "52.02.18",
                    title: "PODPORA PV V20 - 2120"
                },
                "52.02.08": {
                    sku: "52.02.19",
                    title: "PODPORA PV V30 - 2120"
                },
                "52.02.13": {
                    sku: "52.02.12",
                    title: "PODPORA PV 1 H15 – 1052"
                },
                "52.02.09": {
                    sku: "52.02.14",
                    title: "PODPORA PV 1 H20 – 1052"
                },
                "52.02.10": {
                    sku: "52.02.15",
                    title: "PODPORA PV 1 H30 – 1052"
                },
                "52.02.11": {
                    sku: "52.02.16",
                    title: "PODPORA PV 2 H30 – 1052"
                },
                "52.04.04": {
                    sku: "52.04.13",
                    title: "WZMOCNIENIE PV V15 - 1052-2120"
                },
                "52.04.05": {
                    sku: "52.04.14",
                    title: "WZMOCNIENIE PV V20 - 1052-2120"
                },
                "52.04.06": {
                    sku: "52.04.15",
                    title: "WZMOCNIENIE PV V30 - 1052-2120"
                },
                "52.04.07": {
                    sku: "52.04.16",
                    title: "WZMOCNIENIE PV 2 H30 - 1052-2120"
                },
                "52.05.27": {
                    sku: "52.05.20",
                    title: "DOCISK PV SKRAJNY 35 - KPL (4 SZT)"
                },
                "52.05.28": {
                    sku: "52.05.21",
                    title: "DOCISK PV ŚRODKOWY 35 – KPL (2 SZT)"
                },
                "52.06.07": {
                    sku: "52.06.13",
                    title: "PROFIL PV44 1VB – 1052 (2 SZT)"
                },
                "52.06.08": {
                    sku: "52.06.14",
                    title: "PROFIL PV44 1VR – 1052 (2 SZT)"
                },
                "52.06.09": {
                    sku: "52.06.15",
                    title: "PROFIL PV44 2VB – 1052 (2 SZT)"
                },
                "52.06.10": {
                    sku: "52.06.16",
                    title: "PROFIL PV44 2VR – 1052 (2 SZT)"
                },
                "52.06.11": {
                    sku: "52.06.19",
                    title: "PROFIL PV44 1HB – 2120 (2 SZT.)"
                },
                "52.06.12": {
                    sku: "52.06.20",
                    title: "PROFIL PV44 1HR – 2120 (2 SZT.)"
                }
            },
            replacementsForRisen: {
                "52.06.11": {
                    sku: "52.06.21",
                    title: "PROFIL PV44 1HB – 1852 (2 SZT.)"
                },
                "52.06.12": {
                    sku: "52.06.22",
                    title: "PROFIL PV44 1HR – 1852 (2 SZT.)"
                }
            },
            replacementsForJinko: {
                "52.02.13": {
                    sku: "52.02.12",
                    title: "PODPORA PV 1 H15 – 1052"
                },
                "52.02.09": {
                    sku: "52.02.14",
                    title: "PODPORA PV 1 H20 – 1052"
                },
                "52.02.10": {
                    sku: "52.02.15",
                    title: "PODPORA PV 1 H30 – 1052"
                },
                "52.02.11": {
                    sku: "52.02.16",
                    title: "PODPORA PV 2 H30 – 1052"
                },
                "52.04.04": {
                    sku: "52.04.09",
                    title: "WZMOCNIENIE PV V15 – 1052"
                },
                "52.04.05": {
                    sku: "52.04.10",
                    title: "WZMOCNIENIE PV V20 – 1052"
                },
                "52.04.06": {
                    sku: "52.04.11",
                    title: "WZMOCNIENIE PV V30 – 1052"
                },
                "52.05.27": {
                    sku: "52.05.32",
                    title: "DOCISK PV SKRAJNY 30 CZARNY - KPL (4 SZT.)"
                },
                "52.05.28": {
                    sku: "52.05.33",
                    title: "DOCISK PV ŚRODKOWY 30 CZARNY - KPL (2SZT)"
                },
                "52.06.07": {
                    sku: "52.06.13",
                    title: "PROFIL PV44 1VB – 1052 (2 SZT)"
                },
                "52.06.08": {
                    sku: "52.06.14",
                    title: "PROFIL PV44 1VR – 1052 (2 SZT)"
                },
                "52.06.09": {
                    sku: "52.06.15",
                    title: "PROFIL PV44 2VB – 1052 (2 SZT)"
                },
                "52.06.10": {
                    sku: "52.06.16",
                    title: "PROFIL PV44 2VR – 1052 (2 SZT)"
                },
                "52.06.11": {
                    sku: "52.06.19",
                    title: "PROFIL PV44 1HB – 2120 (2 SZT.)"
                },
                "52.06.12": {
                    sku: "52.06.20",
                    title: "PROFIL PV44 1HR – 2120 (2 SZT.)"
                }
            },
            replacementsForJinko395: {
                "52.02.06": {
                    sku: "52.02.20",
                    title: "PODPORA PV V15 - 1855"
                },
                "52.02.07": {
                    sku: "52.02.21",
                    title: "PODPORA PV V20 - 1855"
                },
                "52.02.08": {
                    sku: "52.02.22",
                    title: "PODPORA PV V30 - 1855"
                },
                "52.02.09": {
                    sku: "52.02.24",
                    title: "PODPORA PV 1 H20 - 1029"
                },
                "52.02.10": {
                    sku: "52.02.25",
                    title: "PODPORA PV 1 H30 – 1029"
                },
                "52.02.11": {
                    sku: "52.02.26",
                    title: "PODPORA PV 2 H30 – 1029"
                },
                "52.04.04": {
                    sku: "52.04.17",
                    title: "WZMOCNIENIE PV V15 – 1029"
                },
                "52.04.05": {
                    sku: "52.04.18",
                    title: "WZMOCNIENIE PV V20 – 1029"
                },
                "52.04.06": {
                    sku: "52.04.19",
                    title: "WZMOCNIENIE PV V30 – 1029"
                },
                "52.04.07": {
                    sku: "52.04.16",
                    title: "WZMOCNIENIE PV 2 H30 - 1052-2120"
                },
                "52.05.27": {
                    sku: "52.05.32",
                    title: "DOCISK PV SKRAJNY 30 CZARNY - KPL (4 SZT.)"
                },
                "52.05.28": {
                    sku: "52.05.33",
                    title: "DOCISK PV ŚRODKOWY 30 CZARNY - KPL (2SZT)"
                },
                "52.06.07": {
                    sku: "52.06.23",
                    title: "PROFIL PV44 1VB – 1029 (2 SZT)"
                },
                "52.06.08": {
                    sku: "52.06.24",
                    title: "PROFIL PV44 1VR – 1029 (2 SZT)"
                },
                "52.06.09": {
                    sku: "52.06.25",
                    title: "PROFIL PV44 2VB – 1029 (2 SZT)"
                },
                "52.06.10": {
                    sku: "52.06.26",
                    title: "PROFIL PV44 2VR – 1029 (2 SZT)"
                },
                "52.06.11": {
                    sku: "52.06.27",
                    title: "PROFIL PV44 1HB – 1855 (2 SZT.)"
                },
                "52.06.12": {
                    sku: "52.06.28",
                    title: "PROFIL PV44 1HR – 1855 (2 SZT.)"
                },
                "52.08.03": {
                    sku: "52.08.23",
                    title: "PROFIL WZDŁUŻNY C80 4H-MG - 1029"
                },
                "52.08.04": {
                    sku: "52.08.24",
                    title: "PROFIL POPRZECZNY C80 4H-MG - 1029"
                },
                "52.08.12": {
                    sku: "52.08.25",
                    title: "PROFIL WZDŁUŻNY C80 2V-MG - 1029"
                },
                "52.08.13": {
                    sku: "52.08.27",
                    title: "DOCISK PV ŚRODKOWY 30 - M6 KPL (6SZT) - CZARNY - MG"
                },
                "52.08.14": {
                    sku: "52.08.26",
                    title: "DOCISK PV SKRAJNY 30 - M6 KPL (4SZT) - CZARNY - MG"
                },
                "52.08.15": {
                    sku: "52.08.28",
                    title: "DOCISK PV ŚRODKOWY 30 - M6 KPL (4SZT) - CZARNY - MG"
                }
            },
            withoutBfReplacements: {
                "52.05.27": {
                    sku: "52.05.20",
                    title: "DOCISK PV SKRAJNY 35 - KPL (4 SZT)"
                },
                "52.05.28": {
                    sku: "52.05.21",
                    title: "DOCISK PV ŚRODKOWY 35 – KPL (2 SZT)"
                },
                "52.05.30": {
                    sku: "52.05.34",
                    title: "DOCISK PV SKRAJNY 40 - KPL (4 SZT)"
                },
                "52.05.31": {
                    sku: "52.05.35",
                    title: "DOCISK PV ŚRODKOWY 40 – KPL (2 SZT)"
                }
            }
        }),
        computed: {
            disableBfSwitch() {
                return "Ja Solar" !== this.manufacturer
            },
            hiddenGround() {
                return "Ja Solar" !== this.manufacturer
            },
            modulesCount() {
                let t = 0;
                return this.kinds.forEach((e,o)=>{
                        const a = this.getKindCount(o);
                        t += a["1B"] + 2 * a["2B"] + a["1R"] + 2 * a["2R"]
                    }
                ),
                    t
            },
            panelsPower() {
                switch (this.manufacturer) {
                    case "Ja Solar":
                        return [{
                            name: "mniejsza niż 370W",
                            value: "<370"
                        }, {
                            name: "pomiędzy 370W a 385W",
                            value: "370-385"
                        }, {
                            name: "większa niż 385W",
                            value: ">385"
                        }];
                    case "Jinko":
                        return [{
                            name: "pomiędzy 370W a 385W",
                            value: "370-385"
                        }, {
                            name: "większa niż 385W",
                            value: ">385"
                        }];
                    default:
                        return []
                }
            },
            summary() {
                const t = {};
                return this.kinds.forEach((e,o)=>{
                        const a = this.getItems(o);
                        a.forEach(e=>{
                                e.children.forEach(e=>{
                                        t[e.halfProduct] || (t[e.halfProduct] = 0),
                                            t[e.halfProduct] += e.sum
                                    }
                                )
                            }
                        )
                    }
                ),
                    Object.keys(t).forEach(e=>{
                            t[e] || delete t[e]
                        }
                    ),
                    t
            },
            table() {
                const t = Object.keys(this.summary).map(t=>({
                    code: P[t].code,
                    name: t,
                    sum: this.summary[t] || 0
                }));
                return this.gasketSwitch && this.modulesCount && t.push({
                    code: "33.43.01",
                    name: "PODKŁADKA UZIEMIAJĄCA PV",
                    sum: 2 * (Math.max(2, this.modulesCount) - 1) || 0
                }),
                "Risen" === this.manufacturer && t.forEach(t=>{
                        const e = this.replacementsForRisen[t.code];
                        e && (t.code = e.sku,
                            t.name = e.title)
                    }
                ),
                "Jinko" === this.manufacturer && ("370-385" === this.panelPower && t.forEach(t=>{
                        const e = this.replacementsForJinko[t.code];
                        e && (t.code = e.sku,
                            t.name = e.title)
                    }
                ),
                ">385" === this.panelPower && t.forEach(t=>{
                        const e = this.replacementsForJinko395[t.code];
                        e && (t.code = e.sku,
                            t.name = e.title)
                    }
                )),
                "Ja Solar" === this.manufacturer && ("370-385" === this.panelPower && t.forEach(t=>{
                        const e = this.replacementsFor370[t.code];
                        e && (t.code = e.sku,
                            t.name = e.title)
                    }
                ),
                ">385" === this.panelPower && t.forEach(t=>{
                        const e = this.replacementsFor455[t.code];
                        e && (t.code = e.sku,
                            t.name = e.title)
                    }
                )),
                this.bfSwitch || t.forEach(t=>{
                        const e = this.withoutBfReplacements[t.code];
                        e && (t.code = e.sku,
                            t.name = e.title)
                    }
                ),
                    t
            }
        },
        methods: {
            addMounting(t) {
                this.kinds.push({
                    mounting: t,
                    rows: [0],
                    rowsCount: 1
                });
                const e = this.$refs.step1.$children || [];
                e.length && this.$vuetify.goTo(e.slice(-1)[0])
            },
            getItemName(t) {
                const e = this.$t("products." + t);
                return e && 0 !== e.indexOf("products.") ? e : t
            },
            getItems(t) {
                const e = this.getKindCount(t)
                    , o = this.getValidProducts(t);
                return Object.keys(o.technology).map((t,a)=>{
                        const n = e[t];
                        return {
                            name: a + 1 + ". " + t + " [" + n + "]:",
                            children: Object.keys(o.technology[t]).map(e=>{
                                    const a = o.technology[t][e];
                                    return {
                                        halfProduct: e,
                                        sum: a * n
                                    }
                                }
                            )
                        }
                    }
                )
            },
            getKindCount(t) {
                const e = {
                    "1B": 0,
                    "2B": 0,
                    "1R": 0,
                    "2R": 0,
                    BS: 0,
                    RS: 0,
                    ILOSC: 0,
                    PODPORA: 0,
                    SKRAJ: 0,
                    SRODEK: 0,
                    WKRET: 0
                };
                return this.kinds[t].rows.forEach((o,a)=>{
                        let n = this.getRowCount(t, a);
                        for (let t in e)
                            e[t] += n[t]
                    }
                ),
                    e
            },
            getKindStep(t) {
                const e = t.mounting.name || "";
                switch (e) {
                    case "KONSTRUKCJA DWUPODPOROWA POZIOMO 30°":
                    case "KONSTRUKCJA JEDNOPODPOROWA PIONOWO 30°":
                        return 4;
                    case "KONSTRUKCJA 2 POZIOMO":
                        return 2;
                    default:
                        return 1
                }
            },
            getRowCount(t, e) {
                const o = this.kinds[t].mounting || {}
                    , a = !0 === o.double
                    , n = this.kinds[t].rows[e] || 0;
                let i = n ? n + 1 : 0
                    , O = n ? 1 : 0
                    , s = n ? n - 1 : 0;
                "płaska" === o.surface && "poziomo" === o.orientation && (i = a ? n : 2 * n,
                    O = a ? n / 2 : n,
                    s = a ? n / 2 : 0);
                const P = {
                    "1B": 1 === n ? 1 : 0,
                    "2B": n >= 2 ? 1 : 0,
                    "1R": n > 2 ? n % 2 : 0,
                    "2R": n > 3 ? Math.floor((n - 2) / 2) : 0,
                    ILOSC: n,
                    PODPORA: i,
                    SKRAJ: Math.ceil(O),
                    SRODEK: Math.ceil(s)
                };
                if (P["BS"] = P["1B"] + P["2B"],
                    P["RS"] = P["1R"] + 2 * P["2R"] + P["2B"],
                "blachodachówka" === o.surface) {
                    const t = "poziomo" === o.orientation ? 1709 : 1016;
                    P["PODPORA"] = Math.ceil(n * t / o.size),
                        P["WKRET"] = Math.max(P["PODPORA"] - (P["1R"] + 2 * (P["2R"] + P["1B"]) + 3 * P["2B"]), 0)
                }
                return P
            },
            mountingBreadcrumbs(t) {
                const e = [t["mounting"]["group"], this.getSurfaceBreadcrumb(t["mounting"]["surface"]), this.getTypeBreadcrumb(t["mounting"]), this.getOrientationBreadcrumb(t["mounting"])];
                return e.filter(t=>!!t).join(" / ")
            },
            getOrientationBreadcrumb(t) {
                switch (!0) {
                    case "KONSTRUKCJA 1 POZIOMO 30°" === t.name:
                        return "Panele pojedynczo poziomo";
                    case "KONSTRUKCJA PIONOWO 20" === t.name:
                        return "Panele pojedynczo pionowo";
                    case "KONSTRUKCJA 2 POZIOMO" === t.name:
                        return "Panele podwójnie poziomo";
                    case "TRAPEZ" === t.name:
                        return "Panele pionowo";
                    default:
                        return "Panele " + t.orientation
                }
            },
            getSurfaceBreadcrumb(t) {
                switch (t) {
                    case "blachodachówka":
                        return "Blachodachówka";
                    case "dachówka":
                        return "Dachówka";
                    case "bitumiczna":
                        return "Pokrycie bitumiczne";
                    case "rąbek":
                        return "Rąbek stojący";
                    case "trapez":
                        return "Trapez";
                    default:
                        return ""
                }
            },
            getTypeBreadcrumb(t) {
                switch (!0) {
                    case "dachówka" === t.surface:
                        return `Hak ${t.type} mm`;
                    case "blachodachówka" === t.surface:
                        return `Rozstaw krokwi ${t.size} mm`;
                    case "KONSTRUKCJA 2 POZIOMO" === t.name:
                        return "Kąt nachylenia paneli 30°";
                    case "płaska" === t.surface:
                    {
                        const e = t.type.slice(-3);
                        return "Kąt nachylenia paneli " + e
                    }
                    case "trapez" === t.surface:
                    {
                        const e = t.name.slice(-3);
                        return "Długość " + e
                    }
                    default:
                        return ""
                }
            },
            pdf() {
                const t = new jsPDF;
                t.setFont("OpenSans-Regular"),
                    t.autoTable({
                        html: this.$refs.table.$el.getElementsByTagName("table")[0],
                        styles: {
                            font: "OpenSans-Regular"
                        },
                        headStyles: {
                            font: "OpenSans-Regular",
                            fontStyle: "OpenSans-Regular"
                        }
                    }),
                    t.save("table.pdf")
            },
            print() {
                this.$htmlToPaper("mountingCalculatorSummary")
            },
            showRowInfo(t) {
                return t && 0 !== t.name.indexOf("KONSTRUKCJA")
            },
            remove(t) {
                this.kinds.splice(t, 1)
            },
            async send() {
                const t = await fetch("/wp-json/hewalex-zones/v2/mounting", {
                    method: "POST",
                    body: JSON.stringify(this.table)
                }), e = await t.json();
                e.hash && (window.location.href = "https://sklep.hewalex.pl/hewalex-order/" + e.hash)
            },
            updateRow(t, e, o) {
                this.kinds[t].rows[e - 1] = o,
                    this.kinds = JSON.parse(JSON.stringify(this.kinds))
            },
            getValidProducts(t) {
                const e = this.kinds[t].mounting.name;
                return r.find(t=>t.mounting === e) || {}
            }
        },
        watch: {
            kinds: {
                handler: t=>{
                    Object.keys(t).forEach(e=>{
                            const o = t[e].rowsCount - t[e].rows.length;
                            for (var a = 0; a < o; a++)
                                t[e].rows.push(0);
                            for (var n = -1 * o; n > 0; n--)
                                t[e].rows.pop()
                        }
                    )
                }
                ,
                deep: !0
            },
            manufacturer(t) {
                switch (this.step = t ? 1 : 0,
                    t) {
                    case "Jinko":
                        this.bfSwitch = !0;
                        break;
                    case "Risen":
                        this.bfSwitch = !1;
                        break;
                    default:
                        break
                }
            }
        },
        components: {
            AddMountingMenu: F,
            ClickableInput: I
        }
    }
        , J = G
        , x = (o("9041"),
        o("0798"))
        , _ = o("8212")
        , j = o("a523")
        , $ = o("24c9")
        , X = o("b974")
        , Q = o("1f4f")
        , q = o("7e85")
        , tt = o("e516")
        , et = o("9c54")
        , ot = o("b73d")
        , at = Object(T["a"])(J, O, s, !1, null, null, null)
        , nt = at.exports;
    E()(at, {
        VAlert: x["a"],
        VAvatar: _["a"],
        VBtn: V["a"],
        VBtnToggle: Z["a"],
        VCol: L["a"],
        VContainer: j["a"],
        VDivider: k["a"],
        VIcon: g["a"],
        VImg: f["a"],
        VLabel: $["a"],
        VRow: W["a"],
        VSelect: X["a"],
        VSimpleTable: Q["a"],
        VStepper: q["a"],
        VStepperContent: tt["a"],
        VStepperItems: et["a"],
        VSwitch: ot["a"]
    });
    var it = {
        props: {
            locale: String,
            showShopButton: Boolean
        },
        mounted() {
            this.locale && (this.$i18n.locale = this.locale)
        },
        name: "MountingCalculator",
        components: {
            Calculator: nt
        }
    }
        , Ot = it
        , st = (o("034f"),
        o("7496"))
        , Pt = o("f6c4")
        , rt = Object(T["a"])(Ot, n, i, !1, null, null, null)
        , lt = rt.exports;
    E()(rt, {
        VApp: st["a"],
        VMain: Pt["a"]
    });
    var ct = o("f309");
    a["a"].use(ct["a"]);
    var Rt = new ct["a"]({
        icons: {
            iconfont: "mdi"
        }
    })
        , St = o("7898")
        , ut = o.n(St)
        , At = o("a925")
        , Tt = o("4bef")
        , pt = o("13e5")
        , Et = o("f2f1");
    At["a"].prototype.getChoiceIndex = function(t, e) {
        if (t = Math.abs(t),
        "pl-PL" !== this.locale)
            return 2 === e ? t ? t > 1 ? 1 : 0 : 1 : t ? Math.min(t, 2) : 0;
        if (0 === t)
            return 0;
        if (1 === t)
            return 1;
        const o = t > 10 && t < 20;
        return !o && t % 10 >= 2 && t % 10 <= 4 || e < 4 ? 2 : 3
    }
        ,
        a["a"].use(At["a"]);
    const dt = new At["a"]({
        locale: "pl",
        fallbackLocale: "pl",
        messages: {
            pl: {
                ...pt
            },
            en: {
                ...Tt
            },
            es: {
                ...Et
            }
        },
        silentTranslationWarn: !0
    });
    a["a"].config.productionTip = !1;
    const Ct = {
        name: "_blank",
        specs: ["fullscreen=yes", "titlebar=yes", "scrollbars=yes"],
        styles: ["https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css"]
    };
    a["a"].use(ut.a, Ct);
    const It = document.getElementById("mountingCalculatorApp")
        , mt = a["a"].extend(lt);
    new mt({
        i18n: dt,
        vuetify: Rt,
        el: It,
        propsData: {
            ...It.dataset
        }
    })
},
"64a9": function(t, e, o) {},
"6ae3": function(t, e, o) {},
"7b48": function(t) {
    t.exports = JSON.parse('[{"mounting":"KONSTRUKCJA 2 POZIOMO","noRow":true,"technology":{"ILOSC":{"WZMOCNIENIE PV 2 H30":0.5},"PODPORA":{"PODPORA PV 2 H30 – 996":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"KONSTRUKCJA 1 POZIOMO 30°","noRow":true,"technology":{"PODPORA":{"PODPORA PV 1 H30 – 996":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1}}},{"mounting":"KONSTRUKCJA PIONOWO 30°","noRow":true,"technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"PODPORA PV V30":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1,"WZMOCNIENIE PV V30 – 996":1}}},{"mounting":"ŚRUBA","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"ŚRUBA 2GW M10-250 Z ADAPTEREM - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1},"WKRET":{"ŚRUBA M10x30 - KPL":2}}},{"mounting":"ŚRUBA POZIOMO","technology":{"BS":{"PROFIL PV44 1HB – 1690 (2 SZT)":1},"RS":{"PROFIL PV44 1HR – 1690 (2 SZT)":1},"PODPORA":{"ŚRUBA 2GW M10-250 Z ADAPTEREM - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1},"WKRET":{"ŚRUBA M10x30 - KPL":2}}},{"mounting":"BITUM","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"HAK DB200 – KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"BITUM POZIOMO","technology":{"BS":{"PROFIL PV44 1HB – 1690 (2 SZT)":1},"RS":{"PROFIL PV44 1HR – 1690 (2 SZT)":1},"PODPORA":{"HAK DB200 – KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 430","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"HAK DC430 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 430 POZIOMO","technology":{"BS":{"PROFIL PV44 1HB – 1690 (2 SZT)":1},"RS":{"PROFIL PV44 1HR – 1690 (2 SZT)":1},"PODPORA":{"HAK DC430 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"RĄBEK","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"ZACISK RĄBEK PV - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"RĄBEK POZIOMO","technology":{"BS":{"PROFIL PV44 1HB – 1690 (2 SZT)":1},"RS":{"PROFIL PV44 1HR – 1690 (2 SZT)":1},"PODPORA":{"ZACISK RĄBEK PV - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"TRAPEZ 300","technology":{"PODPORA":{"PROFIL TRAPEZ 300 – KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"TRAPEZ 400","technology":{"PODPORA":{"PROFIL TRAPEZ 400 – KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 530","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"HAK DC530 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 530 POZIOMO","technology":{"BS":{"PROFIL PV44 1HB – 1690 (2 SZT)":1},"RS":{"PROFIL PV44 1HR – 1690 (2 SZT)":1},"PODPORA":{"HAK DC530 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 500","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"HAK DC500 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 500 POZIOMO","technology":{"BS":{"PROFIL PV44 1HB – 1690 (2 SZT)":1},"RS":{"PROFIL PV44 1HR – 1690 (2 SZT)":1},"PODPORA":{"HAK DC500 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 470","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"HAK DC470 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"DACHÓWKA 470 POZIOMO","technology":{"BS":{"PROFIL PV44 1HB – 1690 (2 SZT)":1},"RS":{"PROFIL PV44 1HR – 1690 (2 SZT)":1},"PODPORA":{"HAK DC470 - KPL (2 SZT)":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1}}},{"mounting":"KONSTRUKCJA 1 POZIOMO 15°","technology":{"PODPORA":{"PODPORA PV 1 H15 – 996":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1}}},{"mounting":"KONSTRUKCJA 1 POZIOMO 20°","technology":{"PODPORA":{"PODPORA PV 1 H20 – 996":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1}}},{"mounting":"KONSTRUKCJA PIONOWO 20°","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"PODPORA PV V20":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1,"WZMOCNIENIE PV V20 – 996":1}}},{"mounting":"KONSTRUKCJA PIONOWO 15°","technology":{"1B":{"PROFIL PV44 1VB – 996 (2 SZT)":1},"2B":{"PROFIL PV44 2VB – 996 (2 SZT)":1},"1R":{"PROFIL PV44 1VR – 996 (2 SZT)":1},"2R":{"PROFIL PV44 2VR – 996 (2 SZT)":1},"PODPORA":{"PODPORA PV V15":1},"SKRAJ":{"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":1},"SRODEK":{"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":1,"WZMOCNIENIE PV V15 – 996":1}}},{"mounting":"KONSTRUKCJA DWUPODPOROWA POZIOMO 30°","noRow":true,"technology":{"ILOSC":{"DOCISK PV SKRAJNY 35 - M6-MG KPL (4SZT)":0.25,"DOCISK PV ŚRODKOWY 35 - M6-MG KPL (6SZT)":0.25,"PODPORA PRZEDNIA C80 4H-MG":0.25,"PODPORA TYLNA C80 4H-MG":0.25,"PROFIL WZDŁUŻNY C80 4H-MG - 996":0.5,"PROFIL POPRZECZNY C80 4H-MG - 996":0.5,"ZESTAW ŚRUB MONTAŻOWYCH 4H-MG":0.25},"SKRAJ":{"PODPORA PRZEDNIA C80 4H-MG":1,"PODPORA TYLNA C80 4H-MG":1,"ZESTAW ŚRUB MONTAŻOWYCH 4H-MG":1}}},{"mounting":"KONSTRUKCJA JEDNOPODPOROWA PIONOWO 30°","noRow":true,"technology":{"ILOSC":{"DOCISK PV ŚRODKOWY 35 - M6-MG KPL (4SZT)":0.5,"ŁĄCZNIK PODPORY C80 2V-MG":0.25,"PODPORA PRZEDNIA C80 2V-MG":0.25,"PODPORA TYLNA C80 2V-MG":0.25,"PROFIL WZDŁUŻNY C80 2V-MG - 996":1,"PROFIL POPRZECZNY C80 2V-MG":0.25,"WZMOCNIENIE PRZEDNIE C80 2V-MG":0.25,"WZMOCNIENIE TYLNE C80 2V-MG":0.25,"ZESTAW ŚRUB MONTAŻOWYCH 2V-MG":0.25},"SKRAJ":{"DOCISK PV SKRAJNY 35 - M6-MG KPL (4SZT)":2,"DOCISK PV ŚRODKOWY 35 - M6-MG KPL (4SZT)":-1,"ŁĄCZNIK PODPORY C80 2V-MG":1,"PODPORA PRZEDNIA C80 2V-MG":1,"PODPORA TYLNA C80 2V-MG":1,"PROFIL POPRZECZNY C80 2V-MG":1,"PROFIL SKRAJNY C80 2V-MG":8,"WZMOCNIENIE PRZEDNIE C80 2V-MG":1,"WZMOCNIENIE TYLNE C80 2V-MG":1,"ZESTAW ŚRUB MONTAŻOWYCH 2V-MG":1}}}]')
},
9041: function(t, e, o) {
    "use strict";
    o("6ae3")
},
bc29: function(t) {
    t.exports = JSON.parse('{"PROFIL PV44 1VB – 996 (2 SZT)":{"code":"52.06.07"},"PROFIL PV44 1VR – 996 (2 SZT)":{"code":"52.06.08"},"PROFIL PV44 2VB – 996 (2 SZT)":{"code":"52.06.09"},"PROFIL PV44 2VR – 996 (2 SZT)":{"code":"52.06.10"},"PROFIL PV44 1HB – 1690 (2 SZT)":{"code":"52.06.11"},"PROFIL PV44 1HR – 1690 (2 SZT)":{"code":"52.06.12"},"DOCISK PV SKRAJNY 35 - KPL (4 SZT)":{"code":"52.05.20"},"DOCISK PV ŚRODKOWY 35 – KPL (2 SZT)":{"code":"52.05.21"},"DOCISK PV SKRAJNY 35 CZARNY - KPL (4 SZT)":{"code":"52.05.27"},"DOCISK PV ŚRODKOWY 35 CZARNY – KPL (2 SZT)":{"code":"52.05.28"},"ŚRUBA 2GW M10-250 Z ADAPTEREM - KPL (2 SZT)":{"code":"52.03.15"},"HAK DC430 - KPL (2 SZT)":{"code":"52.01.20"},"HAK DC470 - KPL (2 SZT)":{"code":"52.01.21"},"HAK DC500 - KPL (2 SZT)":{"code":"52.01.22"},"HAK DC530 - KPL (2 SZT)":{"code":"52.01.23"},"HAK DK430 - KPL (2 SZT)":{"code":"52.01.24"},"HAK DB200 – KPL (2 SZT)":{"code":"52.01.25"},"ZACISK RĄBEK PV - KPL (2 SZT)":{"code":"52.05.36"},"PROFIL TRAPEZ 300 – KPL (2 SZT)":{"code":"52.05.23"},"PROFIL TRAPEZ 400 – KPL (2 SZT)":{"code":"52.05.29"},"PODPORA PV V15":{"code":"52.02.06"},"WZMOCNIENIE PV V15 – 996":{"code":"52.04.04"},"PODPORA PV V20":{"code":"52.02.07"},"WZMOCNIENIE PV V20 – 996":{"code":"52.04.05"},"PODPORA PV V30":{"code":"52.02.08"},"WZMOCNIENIE PV V30 – 996":{"code":"52.04.06"},"PODPORA PV 1 H15 – 996":{"code":"52.02.13"},"PODPORA PV 1 H20 – 996":{"code":"52.02.09"},"PODPORA PV 1 H30 – 996":{"code":"52.02.10"},"PODPORA PV 2 H30 – 996":{"code":"52.02.11"},"WZMOCNIENIE PV 2 H30":{"code":"52.04.07"},"ŚRUBA 2GW M10-250":{"code":"52.03.13"},"ŚRUBA 2GW M10-250 Z ADAPTEREM":{"code":"52.03.14"},"ŚRUBA M10x30 - KPL":{"code":"52.03.16"},"WKRĘT DOCISKOWY M10 - KPL":{"code":"52.03.11"},"ZESTAW PROFILI 40X40 BAZA 1":{"code":"52.06.00"},"ZESTAW MONTAŻOWY BAZA 2 35":{"code":"52.05.11"},"ZESTAW MONTAŻOWY ROZBUDOWA 2 35":{"code":"52.05.15"},"ZESTAW MONTAŻOWY BAZA 1 35":{"code":"52.05.10"},"ZESTAW MONTAŻOWY POZIOMY 2 35":{"code":"52.05.13"},"ŚRUBY DO UCHWYTU 2B":{"code":"52.03.02"},"ŚRUBY DO UCHWYTU 1B":{"code":"52.03.00"},"ŚRUBY DO UCHWYTU 2R":{"code":"52.03.03"},"ZESTAW MONTAŻOWY RĄBEK BAZA 2":{"code":"52.05.05"},"ZESTAW MONTAŻOWY RĄBEK BAZA 1":{"code":"52.05.04"},"ZESTAW MONTAŻOWY RĄBEK ROZBUDOWA 2":{"code":"52.05.07"},"ZESTAW MONTAŻOWY TRAPEZ BAZA 1":{"code":"52.05.16"},"ŚRUBA DWUGWINTOWA KPL DODATEK":{"code":"7182"},"HAK Z REGULACJĄ KPL DODATEK":{"code":"7183"},"RĄBEK KPL DODATEK":{"code":"7184"},"TRAPEZ KPL DODATEK":{"code":"7186"},"ZASTRZAŁ KONSTRUKCJI POZIOMEJ ŁĄCZNIK":{"code":"7153"},"KARTON 280X250X200 - PRZEPUSTNICA DN160":{"code":"4989"},"PODPORA PRZEDNIA C80 4H-MG":{"code":"52.08.01"},"PODPORA TYLNA C80 4H-MG":{"code":"52.08.02"},"PROFIL WZDŁUŻNY C80 4H-MG - 996":{"code":"52.08.03"},"PROFIL POPRZECZNY C80 4H-MG - 996":{"code":"52.08.04"},"DOCISK PV ŚRODKOWY 35 - M6-MG KPL (6SZT)":{"code":"52.08.13"},"DOCISK PV SKRAJNY 35 - M6-MG KPL (4SZT)":{"code":"52.08.14"},"ZESTAW ŚRUB MONTAŻOWYCH 4H-MG":{"code":"52.08.16"},"PODPORA PRZEDNIA C80 2V-MG":{"code":"52.08.05"},"PODPORA TYLNA C80 2V-MG":{"code":"52.08.06"},"WZMOCNIENIE PRZEDNIE C80 2V-MG":{"code":"52.08.07"},"WZMOCNIENIE TYLNE C80 2V-MG":{"code":"52.08.08"},"PROFIL POPRZECZNY C80 2V-MG":{"code":"52.08.09"},"ŁĄCZNIK PODPORY C80 2V-MG":{"code":"52.08.10"},"PROFIL SKRAJNY C80 2V-MG":{"code":"52.08.11"},"PROFIL WZDŁUŻNY C80 2V-MG - 996":{"code":"52.08.12"},"DOCISK PV ŚRODKOWY 35 - M6-MG KPL (4SZT)":{"code":"52.08.15"},"ZESTAW ŚRUB MONTAŻOWYCH 2V-MG":{"code":"52.08.17"}}')
},
f2f1: function(t) {
    t.exports = JSON.parse('{"artykuly":"Articulado","bitumiczna":"bbituminoso","blachodachówka":"acero corrugado","dachowka-opis":"La medición debe realizarse midiendo el azulejo desde su bloqueo hasta su final","dachówka":"azulejo","dlugosc-haka":"Longitud del gancho","dlugosc-profilu":"Longitud del perfil","dodaj-mocowanie":"agregar un corchete","domyslny":"predeterminado","drukuj":"imprimir","generuj":"cenerar","grunt-info":"CON ESTE TIPO DE MONTAJE, EL NÚMERO DE PANELES DEBE SER MULTIPLICADOR DE 4","ilosc":"cantidad","ilosc-paneli":" cantidad de módulos","kat-15":"15° ángulo","kat-20":"20° ángulo","kat-30":"30° ángulo","kąt 15°":"15° ángulo","kąt 20°":"20° ángulo","kąt 30°":"30° ángulo","liczba-paneli":"dar cuenta de módulos ","liczba-rzedow":"dar cuenta de filas","nr-kat":"No Cat","orientacja":"orientación","pi":"modulo verticalmente","panel-poziomo":"modulo horizontalmente","pionowo":"verticalmente","płaska":"plano","podwojnie-poziomo-info":"CON ESTE TIPO DE MONTAJE, EL NÚMERO DE PANELES DEBE SER INCLUSO","powierzchnia":"superficie","powrot":"retorno","poziomo":"horizontalmente","rąbek":"techo de costura","rozstaw":"espaciamiento","rozstaw-mm":"Viga espaciamiento en mm","trapez":"trapezoidales","typ":"tipo","usun":"eliminar","w-rzedzie":"en una fila","wybierz":"seleccionar","zamknij":"cerca","zapisz-pdf":"Guardar como PDF","surface":{"grunt":"terreno","plaski":"techo plano","skosny":"techo inclinado"},"types":{"bitumiczne":"Cobertura bituminosa","blachodachowka":"Acero corrugado","dachowka":"Baldosa","dwupodporowa-poziomo":"Doble support horizontalmente","jednopodporowa-pionowo":"Verticalmente","podwojnie-poziom":"Doble horizontalmente","pojedynczo-poziom":"Horizontalmente","pojedynczo-pion":"Verticalmente","rabek":"Techo de costura","trapez":"Trapezoidales"},"products":{"PROFIL PV44 1VB – 996 (2 SZT)":"PERFIL PV 40X40 1VB – EQUIPO (2 PCS)","PROFIL PV44 1VR – 996 (2 SZT)":"PERFIL PV 40X40 1VR – EQUIPO (2 PCS)","PROFIL PV44 2VB – 996 (2 SZT)":"PERFIL PV 40X40 2VB – EQUIPO (2 PCS)","PROFIL PV44 2VR – 996 (2 SZT)":"PERFIL PV 40X40 2VR – EQUIPO (2 PCS)","PROFIL PV44 1HB – 1690 (2 SZT)":"PERFIL PV 40X40 1HB – EQUIPO (2 PCS)","PROFIL PV44 1HR – 1690 (2 SZT)":"PERFIL PV 40X40 1HR – EQUIPO (2 PCS)","DOCISK PV SKRAJNY 35 - KPL (4 SZT)":"PV LATERAL PRENSOR  - EQUIPO (4 PCS)","DOCISK PV ŚRODKOWY 35 – KPL (2 SZT)":"PV CENTRICO PRENSOR 35 – EQUIPO (2 PCS)","ŚRUBA 2GW M10-250 Z ADAPTEREM - KPL (2 SZT)":"TORNILLO DE DOBLE ROSCA 2GW M10-250 CON ADAPTADOR - EQUIPO (2 PCS)","HAK DC430 - KPL (2 SZT)":"GANCHO DC430 – EQUIPO (2 PCS)","HAK DC470 - KPL (2 SZT)":"GANCHO DC470 – EQUIPO (2 PCS)","HAK DC500 - KPL (2 SZT)":"GANCHO DC500 – EQUIPO (2 PCS)","HAK DC530 - KPL (2 SZT)":"GANCHO DC530 – EQUIPO (2 PCS)","HAK DK430 - KPL (2 SZT)":"GANCHO DK430 – EQUIPO (2 PCS)","HAK DB200 – KPL (2 SZT)":"GANCHO DB200 – EQUIPO (2 PCS)","ZACISK RĄBEK – KPL (2 SZT)":"COSTURA PRENSOR – EQUIPO (2 PCS)","ZACISK RĄBEK PV - KPL (2 SZT)":"COSTURA PRENSOR PV – EQUIPO (2 PCS)","PROFIL TRAPEZ 300 – KPL (2 SZT)":"TRAPEZOIDALES PERFIL 300 – EQUIPO (2 PCS)","PROFIL TRAPEZ 400 – KPL (2 SZT)":"TRAPEZOIDALES PERFIL 400 – EQUIPO (2 PCS)","PODPORA PV V15":"SOPORTE PV V15","WZMOCNIENIE PV V15 – 996":"PUNTAL PV V15","PODPORA PV V20":"SOPORTE PV V20","WZMOCNIENIE PV V20 – 996":"PUNTAL PV V20","PODPORA PV V30":"SOPORTE PV V30","WZMOCNIENIE PV V30 – 996":"PUNTAL PV V30","PODPORA PV 1 H20 – 996":"SOPORTE PV 1 H20","PODPORA PV 1 H30 – 996":"SOPORTE PV 1 H30","PODPORA PV 2 H30 – 996":"SOPORTEs PV 2 H30","WZMOCNIENIE PV 2 H30":"PUNTAL PV 2 H30","ŚRUBA 2GW M10-250":"TORNILLO DE DOBLE ROSCA 2GW M10-250","ŚRUBA 2GW M10-250 Z ADAPTEREM":"TORNILLO DE DOBLE ROSCA 2GW M10-250 CON ADAPTADOR - EQUIPO (2 PCS)","WKRĘT DOCISKOWY M10 - KPL":"TORNILLO PRISIONERO M10 - EQUIPO","ZESTAW PROFILI 40X40 BAZA 1":"PERFIL EQUIPO 40X40 BASE 1","ZESTAW MONTAŻOWY BAZA 2 35":"MONTAJE EQUIPO BASE 2 35","ZESTAW MONTAŻOWY ROZBUDOWA 2 35":"MOUNTING EQUIPO EXTENSION 2 35","ZESTAW MONTAŻOWY BAZA 1 35":"MONTAJE EQUIPO BASE 1 35","ZESTAW MONTAŻOWY POZIOMY 2 35":"MONTAJE EQUIPO HORIZONTALMENTE 2 35","ŚRUBY DO UCHWYTU 2B":"TORNILLO DE SOPORTE 2B","ŚRUBY DO UCHWYTU 1B":"TORNILLO DE SOPORTE 1B","ŚRUBY DO UCHWYTU 2R":"TORNILLO DE SOPORTE 2R","ZESTAW MONTAŻOWY RĄBEK BAZA 2":"MONTAJE EQUIPO COSTURA  BASE 2","ZESTAW MONTAŻOWY RĄBEK BAZA 1":"MONTAJE EQUIPO COSTURA  BASE 1","ZESTAW MONTAŻOWY RĄBEK ROZBUDOWA 2":"MONTAJE EQUIPO COSTURA BASE EXTENSION 2","ZESTAW MONTAŻOWY TRAPEZ BAZA 1":"MONTAJE EQUIPO TRAPEZOIDALES BASE 1","ŚRUBA DWUGWINTOWA KPL DODATEK":"EQUIPO TORNILLO DE DOBLE ROSCA EXTENSION","HAK Z REGULACJĄ KPL DODATEK":"AJUSTABLE HOOK EQUIPO EXTENSION","RĄBEK KPL DODATEK":"COSTURA EQUIPO EXTENSION","TRAPEZ KPL DODATEK":"TRAPEZOIDALES EQUIPO EXTENSION","ZASTRZAŁ KONSTRUKCJI POZIOMEJ ŁĄCZNIK":"PUNTAL HORIZONTALMENTEEQUIPO","KARTON 280X250X200 - PRZEPUSTNICA DN160":"CAJA DE CARTÓN 280X250X200 - ACELERADOR DN160","PODPORA PRZEDNIA C80 4H":"SOPORTE DELANTERO C80 4H","PODPORA TYLNA C80 4H":"SOPORTE TRASEROC80 4H","PROFIL WZDŁUŻNY C80 4H":"PERFIL LONGITUDINAL C80 4H","PROFIL POPRZECZNY C80 4H":"PERFIL TRANSVERSAL C80 4H","DOCISK PV ŚRODKOWY 35 - M6 KPL (6SZT)":"PV CENTRICO PRENSOR 35 - M6 EQUIPO (6PCS)","DOCISK PV SKRAJNY 35 - M6 KPL (4SZT)":"PV LATERAL PRENSOR - M6 EQUIPO (4PCS)","ZESTAW ŚRUB MONTAŻOWYCH 4H":"JUEGO DE TORNILLOS  4H","PODPORA PRZEDNIA C80 2V":"SOPORTE DELANTERO C80 2V","PODPORA TYLNA C80 2V":"SOPORTE TRASERO C80 2V","WZMOCNIENIE PRZEDNIE C80 2V":"PUNTO DELANTERO C80 2V","WZMOCNIENIE TYLNE C80 2V":"PUNTO TRASERO C80 2V","PROFIL POPRZECZNY C80 2V":"PERFIL TRANSVERSAL C80 2V","ŁĄCZNIK PODPORY C80 2V":"CONECTOR DE SOPORTE C80 2V","PROFIL SKRAJNY C80 2V":"PERFIL DE BORDE C80 2V","PROFIL WZDŁUŻNY C80 2V":"PERFIL LONGITUDINAL C80 2V","DOCISK PV ŚRODKOWY 35 - M6 KPL (4SZT)":"PV CENTRICO PRENSOR 35 - M6 EQUIPO (4PCS)","ZESTAW ŚRUB MONTAŻOWYCH 2V":"JUEGO DE TORNILLOS  2V"}}')
}
});
//# sourceMappingURL=app.206b7bba.js.map
