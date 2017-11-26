use home_todo_tasks;
db.createUser(
    {
        user: "mongodb_user",
        pwd: "mongodb_pass",
        roles: [{
            role: "dbOwner",
            db: "home_todo_tasks"
        }]
    }
);