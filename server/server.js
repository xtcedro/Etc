const express = require('express');
const sqlite3 = require('sqlite3').verbose();
const bodyParser = require('body-parser');
const cors = require('cors');
const path = require('path');

const app = express();
const port = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, '../public')));

// Initialize SQLite database
const db = new sqlite3.Database('./database/appointments.db', (err) => {
    if (err) {
        console.error('Error connecting to the database:', err.message);
    } else {
        console.log('Connected to the appointments database.');
    }
});

// Create appointments table if it doesn't exist
db.run(`CREATE TABLE IF NOT EXISTS appointments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    phone TEXT NOT NULL,
    email TEXT NOT NULL,
    repairType TEXT NOT NULL,
    date TEXT NOT NULL,
    time TEXT NOT NULL
)`);

// Route to handle appointment bookings
app.post('/book', (req, res) => {
    const { name, phone, email, repairType, date, time } = req.body;

    if (!name || !phone || !email || !repairType || !date || !time) {
        return res.status(400).json({ message: 'All fields are required.' });
    }

    const query = `INSERT INTO appointments (name, phone, email, repairType, date, time) VALUES (?, ?, ?, ?, ?, ?)`;

    db.run(query, [name, phone, email, repairType, date, time], function(err) {
        if (err) {
            console.error('Error booking appointment:', err.message);
            return res.status(500).json({ message: 'Error booking appointment.' });
        }
        res.json({ message: 'Appointment booked successfully!' });
    });
});

// Route to fetch all appointments (for admin purposes)
app.get('/appointments', (req, res) => {
    db.all(`SELECT * FROM appointments`, [], (err, rows) => {
        if (err) {
            console.error('Error fetching appointments:', err.message);
            return res.status(500).json({ message: 'Error fetching appointments.' });
        }
        res.json(rows);
    });
});

// Start the server
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
