# SportsRecruits

### Fullstack Engineer Code Challenge

Write at least one controller and a Blade view in Laravel style syntax.

1. Create a new Laravel project. (we recommend installing Valet... https://laravel.com/docs/8.x/valet#introduction)
2. Setup a local database, set the connection settings in the .env file.
3. Import the data from the attached .sql file into your database
4. Place the Eloquent User model attached (which currently includes a scope and a getter) in the app directory.
5. Write a controller and Blade view to display the results for the requirements below
6. Place the PlayersIntegrityTest model attached in the tests directory
7. Fill out the test in the file with the required logic described in the comments of that file. Make sure to use the User Eloquent Model to achieve what you need.

Take the sample data in the attached SQL file.

Write a controller, which when ran in the browser, will select players from the provided database table and will put them on balanced teams (by total team player ranking) for a tournament.
1. Select all the users whose user_type is 'player' from the provided database table
2. Dynamically generate teams based on the number of players you have. The number of teams should be computed in such a way that there should be an even number of teams and each team must have between 18 and 22 players. (Assume the dataset will always fit that criteria)
3. Assign players to teams in a way where each team has at least 1 Goalie (can_play_goalie field in the DB table).
4. Make the assignment algorithm such that it generates teams that are as evenly matched as possible in terms of their players' combined total ranking.
5. When the page is loaded the teams need to be given a random name (use https://github.com/fzaninotto/Faker to generate some fun team names) and display a calculated average player ranking. Example: if there are 20 players on the team, each ranked 4, the team average should be 4.
6. Display the newly generated teams in the browser, along with all players on each team, team name and the average team ranking for each team.
7. Complete the empty method in the PlayersIntegrityTest to achieve what is required in the comments. Here is the documentation on how tests work: https://laravel.com/docs/8.x/testing. Use phpunit to ensure the tests are passing.

The logic should dynamically decide how many teams it will make, how many people it will put on each team, which players it will put on each team, such that if a different dataset is loaded into the database, running the same code will still generate teams that respect the rules above.
