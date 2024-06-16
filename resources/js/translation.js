import messages from '../lang/messages.json';

let currentLanguage = 'en'; // Default language

export function setLanguage(language) {
    currentLanguage = language;
}

export function __(key) {
    return messages[currentLanguage][key] || key;
}
