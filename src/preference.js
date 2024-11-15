function handlePreference(source) {
    let url = window.location.protocol +'//'+ window.location.host+window.location.pathname+"?action="+(!source.checked?"retirerPreference":"ajouterPreference")
    sendData(url, source.id)
}

async function sendData(url, spectacleid) {
    const formData = new FormData();
    formData.append("spectacleid", spectacleid);
    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData,
        });
        await response.text();
    } catch (e) {
        console.error(e);
    }
}