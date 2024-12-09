document.getElementById('appointment-form').addEventListener('submit', async function(event) {
    event.preventDefault();

    const data = {
        name: document.getElementById('name').value,
        phone: document.getElementById('phone').value,
        email: document.getElementById('email').value,
        repairType: document.getElementById('repair-type').value,
        date: document.getElementById('date').value,
        time: document.getElementById('time').value
    };

    try {
        const response = await fetch('/book', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        document.getElementById('confirmation-message').innerText = result.message;
        event.target.reset();
    } catch (error) {
        document.getElementById('confirmation-message').innerText = 'Error booking appointment.';
    }
});
