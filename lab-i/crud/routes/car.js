var express = require("express");
var router = express.Router();
const { DatabaseSync } = require("node:sqlite");
const path = require("node:path");

const dbPath = path.resolve(__dirname, "../data.db");
const db = new DatabaseSync(dbPath);

db.prepare(`
  CREATE TABLE IF NOT EXISTS car (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    brand TEXT NOT NULL,
    model TEXT NOT NULL,
    year INTEGER NOT NULL
  )
`).run();

const count = db.prepare("SELECT COUNT(*) AS c FROM car").get().c;
if (count === 0) {
    db.prepare("INSERT INTO car (brand, model, year) VALUES (?, ?, ?)").run("BMW", "M3", 2018);
    db.prepare("INSERT INTO car (brand, model, year) VALUES (?, ?, ?)").run("Audi", "A4", 2016);
    db.prepare("INSERT INTO car (brand, model, year) VALUES (?, ?, ?)").run("Mercedes", "C200", 2019);
}

router.get("/", (req, res) => {
    const cars = db.prepare("SELECT * FROM car").all();
    res.render("car/list", { cars });
});

router.get("/:id", (req, res) => {
    const id = req.params.id;
    const car = db.prepare("SELECT * FROM car WHERE id = ?").get(id);
    res.render("car/show", { car });
});

router.get("/create/new", (req, res) => {
    res.render("car/create");
});

router.post("/create/new", (req, res) => {
    const { brand, model, year } = req.body;
    db.prepare("INSERT INTO car (brand, model, year) VALUES (?, ?, ?)").run(
        brand,
        model,
        year
    );
    res.redirect("/car");
});

router.get("/edit/:id", (req, res) => {
    const id = req.params.id;
    const car = db.prepare("SELECT * FROM car WHERE id = ?").get(id);
    res.render("car/edit", { car });
});

router.post("/edit/:id", (req, res) => {
    const id = req.params.id;
    const { brand, model, year } = req.body;

    db.prepare(
        "UPDATE car SET brand = ?, model = ?, year = ? WHERE id = ?"
    ).run(brand, model, year, id);

    res.redirect("/car");
});

router.post("/delete/:id", (req, res) => {
    const id = req.params.id;
    db.prepare("DELETE FROM car WHERE id = ?").run(id);
    res.redirect("/car");
});

module.exports = router;
