const express = require('express');
const sqlite3 = require('sqlite3').verbose();
const bodyParser = require('body-parser');
const cors = require('cors');
const path = require('path');
const fs = require('fs');

const app = express();
const port = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, '../public')));

// Initialize SQLite database
const dbPath = './database/appointments.db';
const schemaPath = './database/schema.sql';

// Function to initialize the database
function initializeDatabase() {
    if (!fs.existsSync(dbPath)) {
        const db = new sqlite3.Database(dbPath, (err) => {
            if (err) {
                console.error('Error creating the database:', err.message);
            } else {
                console.log('Database created successfully.');
                const schema = fs.readFileSync(schemaPath, 'utf8');
                db.exec(schema, (err) => {
                    if (err) {
                        console.error('Error executing schema.sql:', err.message);
                    } else {
                        console.log('Database initialized with schema.');
                    }
                    db.close();
                });
            }
        });
    } else {
        console.log('Database already exists.');
    }
}

// Call the function to initialize the database
initializeDatabase();

// Route to handle appointment bookings
app.post('/book', (req, res) => {
    const { name, phone, email, repairType, date, time } = req.body;

    if (!name || !phone || !email || !repairType || !date || !time) {
        return res.status(400).json({ message: 'All fields are required.' });
    }

    const db = new sqlite3.Database(dbPath);

    const query = `INSERT INTO appointments (name, phone, email, repairType, date, time) VALUES (?, ?, ?, ?, ?, ?)`;

    db.run(query, [name, phone, email, repairType, date, time], function(err) {
        if (err) {
            console.error('Error booking appointment:', err.message);
            return res.status(500).json({ message: 'Error booking appointment.' });
        }
        res.json({ message: 'Appointment booked successfully!' });
        db.close();
    });
});

// Route to fetch all appointments (for admin purposes)
app.get('/appointments', (req, res) => {
    const db = new sqlite3.Database(dbPath);

    db.all(`SELECT * FROM appointments`, [], (err, rows) => {
        if (err) {
            console.error('Error fetching appointments:', err.message);
            return res.status(500).json({ message: 'Error fetching appointments.' });
        }
        res.json(rows);
        db.close();
    });
});

// Start the server
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
