const express = require('express');
const cors = require('cors');
const bodyParser = require('body-parser');
const { Pool } = require('pg');  // si PostgreSQL

const app = express();
app.use(cors());
app.use(bodyParser.json());

// Config DB
const pool = new Pool({
    host: process.env.DB_HOST || 'db',
    user: process.env.DB_USER || 'myuser',
    password: process.env.DB_PASSWORD || 'mypassword',
    database: process.env.DB_NAME || 'mydatabase',
});

// Exemple : route pour vérifier que le backend tourne
app.get('/api/health', (req, res) => {
    res.json({ status: 'OK' });
});

// TODO : routes d'authentification, like, etc.

const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
    console.log(`Backend running on port ${PORT}`);
});
