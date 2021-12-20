document.addEventListener('DOMContentLoaded', function(event) {
    // Speichert das erste Formular-Element zwischen (wenn er eins findet)
    const form  = document.getElementsByTagName('form')[0];

    // Setzt das Start- und End-Datum, wenn die Seite geladen wurde
    setStartDate(form.start);
    setEndDate(form.start.value, form.end);

    // Ändert das End-Datum entsprechend des geänderten Start-Datums
    changedDate(form);

    // Validiert die Formular-Eingaben, wenn ein Formular abgeschickt wird
    validate(form, form.name, form.beschreibung, form.start, form.end, form.bezeichnung, form.inhalt);
})

function validate(form, name, beschreibung, startdatum, enddatum, bezeichnung, inhalt) {
    // Wenn ein Formular abgeschickt wird, wird bei allen Input-Feldern (die existieren) die Eingabe überprüft
        // Bei einem Fehler wird eine entsprechende Meldung an den Nutzer gegeben und der Submit wird abgebrochen
    form.addEventListener('submit', function (event) {

        if (!!name) {
            if(!nameIsValid(name)) {
                alert("Der Titel muss mindestens 1 Zeichen lang sein!");
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
                alert("Das Enddatum darf nicht vor dem Startdatum liegen!");
                event.preventDefault()
            }
        }

        if (!!bezeichnung) {
            if(!bezeichnungIsValid(bezeichnung)) {
                alert("Die Kategorie-Bezeichnung muss 1-32 Zeichen enthalten!");
                event.preventDefault()
            }
        }

        if (!!inhalt) {
            if(!inhaltIsValid(inhalt)) {
                alert("Der Inhalt der Antwort muss 1-256 Zeichen enthalten!");
                event.preventDefault()
            }
        }
    });
}

// Überprüft, ob der Name größer als 0 ist
function nameIsValid(name) {
    let isValid = true;
    const length = name.value.length;

    if(length < 1) {
        isValid = false;
    }

    return isValid;
}

// Überprüft, ob die Beschreibung größer als 0 und kleiner gleich 500 ist
function beschreibungIsValid(beschreibung) {
    let isValid = true;
    const length = beschreibung.value.length;

    if(length < 1 || length >= 500) {
        isValid = false;
    }

    return isValid;
}

// Überprüft, ob das Startdatum vor dem Enddatum liegt
function datumIsValid(startdatum, enddatum) {
    let isValid = true;
    const start = toDate(startdatum.value).getTime()
    const end = toDate(enddatum.value).getTime()

    if (end <= start) {
        isValid = false;
    }

    return isValid;

}

// Überprüft, ob die Bezeichnung größer 0 und kleiner gleich 32 ist
function bezeichnungIsValid(bezeichnung) {
    let isValid = true;
    const length = bezeichnung.value.length;

    if(length < 1 || length > 32) {
        isValid = false;
    }

    return isValid;
}

// Überprüft, ob der Inhalt größer 0 und kleiner gleich 250 ist
function inhaltIsValid(inhalt) {
    let isValid = true;
    const length = inhalt.value.length;

    if(length < 1 || length > 250) {
        isValid = false;
    }

    return isValid;
}

// Setzt das Startdatum einer Umfrage auf "Heute +1"
function setStartDate(date) {
    const today = toDate(date.defaultValue);
    today.setDate(today.getDate() + 1);

    date.value = toSqlDate(today);
    return toSqlDate(today);
}

// Setzt das Enddatum einer Umfrage auf "Startdatum +30"
function setEndDate(startDate, endDate) {
    const end = toDate(startDate);
    end.setDate(end.getDate() + 30);

    endDate.value = toSqlDate(end);
}

// Wandelt den Datum-String in ein Date-Objekt um
function toDate(dateStr) {
    var parts = dateStr.split("-")
    return new Date(parts[0], parts[1]-1, parts[2])
}

// Wandelt ein Date-Objekt in deinen String um, der dem SQL-Date-Format "Y-m-dY entspricht
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

// Passt das Enddatum automatisch an (T +30), wenn das Startdatum verändert wird
function changedDate(form) {
    form.start.addEventListener('change', function (event) {
        setEndDate(event.target.value, form.end)
    });
}