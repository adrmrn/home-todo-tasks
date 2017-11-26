use admin;
db.createUser(
    {
        user: "mongodb_admin",
        pwd: "mongodb_pass",
        roles: [{
            role: "root",
            db: "admin"
        }]
    }
);