class Ryuna {
    static modal(params) {
        let { title, body, footer } = params;
        $("#myModal #modal_title").html(title);
        $("#myModal #modal_body").html(body);
        $("#myModal #modal_footer").html(footer);
        $("#myModal").modal("show");
    }

    static close_modal() {
        $("#myModal").modal("hide");
    }

    static large_modal() {
        $("#myModal .modal-dialog").addClass("modal-xl");
        $("#myModal .modal-dialog").on("click", '[data-dismiss="modal"]', function () {
            setTimeout(() => {
                $("#myModal .modal-dialog").removeClass("modal-xl");
            }, 500);
        });
    }

    static blockUI(message) {
        $.blockUI({
            message: '<span class="text-semibold"><img src="' + base_url + "img/loading2.gif" + '" style="height: 21px;">' + (message ? message : " Please Wait") + "</span>",
            baseZ: 10000,
            overlayCSS: {
                backgroundColor: "rgba(0, 0, 0, 0.17)",
                opacity: 1,
                cursor: "wait",
                "backdrop-filter": "blur(2px)",
            },
            css: {
                "z-index": 10020,
                padding: "10px 5px",
                margin: "0px",
                width: "20%",
                top: "40%",
                left: "40%",
                "text-align": "center",
                color: "rgba(82, 95, 127, 1)",
                border: "0px",
                "background-color": "rgb(255, 255, 255)",
                cursor: "wait",
                "border-radius": "10px",
                // 'border': '2px rgba(82, 95, 127, 1) solid',
                "font-size": "16px",
                "min-width": "95px",
            },
        });
    }

    static blockElement(element, message) {
        $(element).block({
            message: '<span class="text-semibold"><img src="' + base_url + "img/loading2.gif" + '" style="height: 21px;">' + (message ? message : " Please Wait") + "</span>",
            baseZ: 10000,
            overlayCSS: {
                backgroundColor: "rgba(0, 0, 0, 0.1)",
                opacity: 1,
                cursor: "wait",
                "backdrop-filter": "blur(0.5px)",
                "border-radius": ".4375rem",
            },
            css: {
                "z-index": 10020,
                padding: "10px 5px",
                margin: "0px",
                width: "20%",
                top: "40%",
                left: "40%",
                "text-align": "center",
                color: "rgba(82, 95, 127, 1)",
                border: "0px",
                "background-color": "rgb(255, 255, 255)",
                cursor: "wait",
                "border-radius": ".4375rem",
                // 'border': '2px rgba(82, 95, 127, 1) solid',
                "font-size": "16px",
                "min-width": "95px",
            },
        });
    }

    static unblockUI() {
        $.unblockUI();
    }

    static unblockElement(element) {
        $(element).unblock();
    }

    static input_nominal(element) {
        return new AutoNumeric(element, {
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            emptyInputBehavior: "min",
            minimumValue: "0",
        });
    }

    static input_nominal_multiple(element) {
        new AutoNumeric.multiple(element, {
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            emptyInputBehavior: "min",
            minimumValue: "0",
        });
    }

    static input_percent(element) {
        new AutoNumeric(element, {
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            emptyInputBehavior: "min",
            minimumValue: "0",
            maximumValue: "100",
        });
    }

    static input_percent_multiple(element) {
        new AutoNumeric.multiple(element, {
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            emptyInputBehavior: "min",
            minimumValue: "0",
            maximumValue: "100",
        });
    }

    static input_number_fixed(element) {
        return new AutoNumeric(element, {
            decimalCharacter: ",",
            digitGroupSeparator: ".",
            emptyInputBehavior: "min",
            minimumValue: "0",
            decimalPlaces: "0",
            decimalPlacesRawValue: "0",
        });
    }

    static format_nominal(nominal) {
        return new Intl.NumberFormat("id-ID", { style: "currency", currency: "IDR" }).format(nominal);
    }

    static unformat_nominal(nominal) {
        return new Intl.NumberFormat("id-ID", { currency: "IDR" })
            .formatToParts(nominal)
            .filter(({ type }) => type != "currency")
            .map(({ value }) => value)
            .join("");
    }

    static format_percent(nominal) {
        return new Intl.NumberFormat("id-ID", { currency: "IDR" }).format(nominal) + " %";
    }

    static rstatus(data) {
        data = +data;
        let html = "";
        switch (data) {
            case 0:
                html = '<span class="badge text-white bg-danger">inactive</span>';
                break;
            case 1:
                html = '<span class="badge text-white bg-success">active</span>';
                break;
            case 2:
                html = '<span class="badge text-white bg-yellow">need approval</span>';
                break;
            case 3:
                html = '<span class="badge text-white bg-danger">reject</span>';
                break;
            case 4:
                html = '<span class="badge text-white bg-danger">expired</span>';
                break;
            default:
                html = '<span class="badge text-white bg-secondary"></span>';
                break;
        }
        return html;
    }

    static rstatus_approval(data, type) {
        // console.log(type)
        data = +data;
        let html = "";
        type = type || "product";
        // console.log(data)
        switch (data) {
            case 1:
                html = '<span class="badge text-white bg-primary">approval create</span>';
                break;
            case 2:
                html = '<span class="badge text-white bg-primary">approval update</span>';
                break;
            case 3:
                html = '<span class="badge text-white bg-primary">approval delete</span>';
                break;
            case 4:
                html = '<span class="badge text-white bg-primary">approval soft delete</span>';
                break;
            case 5:
                html = '<span class="badge text-white bg-primary">approval restore</span>';
                break;
            case 6:
                var label = "";
                switch (type) {
                    case "product":
                        label = "fee";
                        break;
                    case "mitra":
                        label = "product";
                        break;
                    case "virtual_account":
                        label = "suspend";
                        break;
                    default:
                        label = "";
                        break;
                }
                html = `<span class="badge text-white bg-primary">approval ${label}</span>`;
                break;
            case 7:
                var label = "";
                switch (type) {
                    case "product":
                        label = "config";
                        break;
                    case "mitra":
                        label = "fee";
                        break;
                    case "virtual_account":
                        label = "unsuspend";
                        break;
                    default:
                        label = "";
                        break;
                }
                html = `<span class="badge text-white bg-primary">approval ${label}</span>`;
                break;
            case 8:
                var label = "";
                switch (type) {
                    case "mitra":
                        label = "user";
                        break;
                    default:
                        label = "user";
                        break;
                }
                html = `<span class="badge text-white bg-primary">approval ${label}</span>`;
                break;
            case 9:
                html = `<span class="badge text-white bg-primary">approval status</span>`;
                break;
            default:
                html = '<span class="badge text-white bg-secondary"></span>';
                break;
        }

        return html;
    }

    static rproduct_type(data) {
        let html = "";
        if (data == "disbursement") {
            html = `<span class="badge badge-success"><i class="fas fa-chevron-down"></i> ${data}</span>`;
        } else if (data == "general") {
            html = `NORMAL`;
        } else {
            html = `<span class="badge badge-danger"><i class="fas fa-chevron-up"></i> ${data.replace("_", " ")}</span>`;
        }
        return html;
    }

    static rstatus_enable(data) {
        data = +data;
        let html = "";
        if (data == 1) {
            html = `<span class="badge badge-success">enabled</span>`;
        } else {
            html = `<span class="badge badge-danger">disabled</span>`;
        }
        return html;
    }

    static rstatus_transaction(data) {
        data = +data;
        let html = "";
        if (data == 0) {
            html = "<span class='badge badge-warning'>MENUNGGU</span>";
        } else if (data == 1) {
            html = "<span class='badge badge-primary'>BERJALAN</span>";
        } else if (data == 2) {
            html = "<span class='badge badge-success'>BERHASIL</span>";
        } else if (data == 3) {
            html = "<span class='badge badge-danger'>GAGAL</span>";
        }

        return html;
    }

    static rstatus_transfer(data) {
        data = +data;
        let html = "";
        switch (data) {
            case 0:
                html = '<span class="badge text-white bg-warning">pending</span>';
                break;
            case 1:
                html = '<span class="badge text-white bg-success">success</span>';
                break;
            case 2:
                html = '<span class="badge text-white bg-danger">failed</span>';
                break;
            default:
                html = '<span class="badge text-white bg-secondary"></span>';
                break;
        }
        return html;
    }

    static leftpad(num, targetLength) {
        return String(num).padStart(targetLength, "0");
    }

    static getSaldo() {
        let url_get_saldo = base_url + "admin/get_saldo";
        $(".saldo-value").html("menyinkronkan ...");

        $(".btn-saldo-refresh").addClass("loading");
        setTimeout(() => {
            $.get(url_get_saldo)
                .done((res) => {
                    let saldo = res?.data.saldo;
                    saldo = Ryuna.format_nominal(saldo);
                    $(".btn-saldo-refresh").removeClass("loading");
                    $(".saldo-value").html(saldo);
                })
                .fail((xhr) => {
                    let saldo = 0;
                    saldo = Ryuna.format_nominal(saldo);
                    $(".btn-saldo-refresh").removeClass("loading");
                    $(".saldo-value").html(saldo);
                });
        }, 2000);
    }

    static noty(type, title, message) {
        title = title && title != null ? `<strong>${title}</strong><br>` : "";
        new Noty({
            type: type,
            theme: "mint",
            timeout: 6000,
            progressBar: true,
            text: `${title}${message}`,
        }).show();
    }

    static summernote(element) {
        return $(element).summernote({
            placeholder: "Ketik Sesuatu",
            tabsize: 2,
            height: 100,
        });
    }

    static isEmail(email) {
        let regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        return regex.test(email);
    }

    static isUsernameValid(username) {
        // username is alphanumeric, underscore, dot, and dash
        let first_rule = /^[a-zA-Z0-9._-]+$/;

        // username is not start with underscore, dot, and dash
        // username is not end with underscore, dot, and dash
        let second_rule = /^[a-zA-Z0-9]+[a-zA-Z0-9._-]*[a-zA-Z0-9]+$/;

        // underscore, dot, and dash is not repeated more than 1 time
        // underscore, dot, and dash is not side by side
        let third_rule = /([._-])[._-]/;

        // username length is 5-20
        let fourth_rule = /^.{5,20}$/;

        return {
            first_rule: first_rule.test(username),
            second_rule: second_rule.test(username),
            third_rule: !third_rule.test(username),
            fourth_rule: fourth_rule.test(username),
        };
    }

    static helpModal(key) {
        Ryuna.blockUI();
        const version = "v1";
        let url = base_url + "admin/wiki_content/help/" + version + "/" + key;
        $.get(url)
            .done((res) => {
                Ryuna.large_modal();
                Ryuna.modal({
                    title: res?.title,
                    body: res?.body,
                    footer: res?.footer,
                });

                Ryuna.unblockUI();
            })
            .fail((xhr) => {
                console.log(xhr);
                Ryuna.unblockUI();
            });
    }

    static heightWindow() {
        let body = document.body,
            html = document.documentElement;

        let height = Math.max(body.scrollHeight, body.offsetHeight, html.clientHeight, html.scrollHeight, html.offsetHeight);
        return height;
    }
}

class Stepper {
    position = 1;
    max_step = 3;

    constructor(props) {
        let { max_step } = props;
        if (max_step) {
            this.max_step = max_step;
        }
    }

    prev() {
        if (this.position > 1) {
            this.position--;
        }
    }

    next() {
        if (this.position < this.max_step) {
            this.position++;
        }
    }
}

class Doom {
    static createElement(tag, prop = {}) {
        let $__el = document.createElement(tag);

        if (prop.attributes) {
            for (let [key, value] of Object.entries(prop.attributes)) {
                if (typeof value === "boolean") {
                    value && $__el.setAttribute(key, value);
                    continue;
                }
                $__el.setAttribute(key, value);
            }
        }

        if (prop.events) {
            for (let [event, callback] of Object.entries(prop.events)) {
                $__el.addEventListener(event, callback);
            }
        }

        for (let child in prop.children) {
            $__el.appendChild(prop.children[child]);
        }

        return $__el;
    }

    static tr(prop = {}) {
        return Doom.createElement("tr", prop);
    }

    static td(prop = {}) {
        return Doom.createElement("td", prop);
    }

    static select(prop = {}) {
        return Doom.createElement("select", prop);
    }

    static input(prop = {}) {
        return Doom.createElement("input", prop);
    }

    static button(prop = {}) {
        return Doom.createElement("button", prop);
    }

    static text(value) {
        return document.createTextNode(value);
    }

    static icon(name) {
        return Doom.createElement("i", {
            attributes: {
                class: name,
            },
        });
    }
}
