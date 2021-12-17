document.addEventListener('DOMContentLoaded', function(event) {
    const form  = document.getElementsByTagName('form')[0];

    setStartDate(form.start);
    setEndDate(form.start.value, form.end);

    changedDate(form);

    validate(form, form.name, form.beschreibung, form.start, form.end, form.bezeichnung, form.inhalt);
})

function validate(form, name, beschreibung, startdatum, enddatum, bezeichnung, inhalt) {
    form.addEventListener('submit', function (event) {

        if (!!name) {
            if(!nameIsValid(name)) {
                console.log("hgkfdj")
                alert("Der Titel muss 1-250 Zeichen lang sein!");
                event.preventDefault()
            }
        }

        if (!!beschreibung) {
            if(!beschreibungIsValid(beschreibung)) {
                alert("Die Beschrebung muss 1-500 Zeichen enthalten!");
                event.preventDefault()
            }
        }

        if (!!startdatum && !!enddatum) {
            if(!datumIsValid(startdatum, enddatum)) {
                event.preventDefault()
            }
        }

        if (!!bezeichnung) {
            if(!bezeichnungIsValid(bezeichnung)) {
                alert("Die Bezeichnung muss 1-32 Zeichen enthalten!");
                event.preventDefault()
            }
        }

        if (!!inhalt) {
            if(!inhaltIsValid(inhalt)) {
                alert("Der Inhalt muss 1-250 Zeichen enthalten!");
                event.preventDefault()
            }
        }
    });
}

function nameIsValid(name) {
    let isValid = true;
    const length = name.value.length;

    if(length < 1 || length > 250) {
        isValid = false;
    }

    console.log("name: ", isValid);
    return isValid;
}

function beschreibungIsValid(beschreibung) {
    let isValid = true;
    const length = beschreibung.value.length;

    if(length < 1 || length > 500) {
        isValid = false;
    }

    console.log("bes: ", isValid);
    return isValid;
}

function datumIsValid(startdatum, enddatum) {
    let isValid = true;
    const start = toDate(startdatum.value).getTime()
    const end = toDate(enddatum.value).getTime()

    if (end <= start) {
        isValid = false;
        alert("Das Enddatum darf nicht vor dem Startdatum liegen!");
    }

    console.log("date: ", isValid);
    return isValid;

}

function bezeichnungIsValid(bezeichnung) {
    let isValid = true;
    const length = bezeichnung.value.length;

    if(length < 1 || length > 32) {
        isValid = false;
    }

    console.log("bez: ", isValid);
    return isValid;
}

function inhaltIsValid(inhalt) {
    let isValid = true;
    const length = inhalt.value.length;

    if(length < 1 || length > 250) {
        isValid = false;
    }

    console.log("inh: ", isValid);
    return isValid;
}

function setStartDate(date) {
    const today = toDate(date.defaultValue);
    today.setDate(today.getDate() + 1);

    date.value = toSqlDate(today);
    return toSqlDate(today);
}

function setEndDate(startDate, endDate) {
    const end = toDate(startDate);
    end.setDate(end.getDate() + 30);

    endDate.value = toSqlDate(end);
}

function toDate(dateStr) {
    var parts = dateStr.split("-")
    return new Date(parts[0], parts[1]-1, parts[2])
}

function toSqlDate(date) {
    const year = String(date.getFullYear());
    let month = String(date.getMonth()+1);
    let day = String(date.getDate());

    if (month.length === 1) {
        month = 0 + month;
    }

    if (day.length === 1) {
        day = 0 + day;
    }


    return year + "-" + month + "-" + day;
}

function changedDate(form) {
    form.start.addEventListener('change', function (event) {
        setEndDate(event.target.value, form.end)
    });
}