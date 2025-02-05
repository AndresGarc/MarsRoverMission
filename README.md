# Mars Rover Mission

## What's my solution?
My solution was to create a small interface using Vue.js and Tailwind, where you can select different rovers that are either on Mars or not and send them movement commands if they are there. The requests are sent to an API built with Laravel, which contains all the logic for moving a rover, retrieving the list of rovers, and more.  

### Where do they move?  
I generated a JSON file containing a 200 x 200 grid simulating the Martian map, where each position contains either an "O" or an "X," indicating whether there is an obstacle. "O" means there are no obstacles, while "X" represents an obstacle at that position.  

In the delivery folder, I've included a file called **mars_map.html**, which provides a visual representation of the Martian map the rovers move on, making it easier to navigate them.  

**IMPORTANT:** The position of the rovers corresponds to their position in the matrix, meaning it is not based on a Cartesian coordinate system.  

Since it is not based on Cartesian coordinates, looking at the map, position (0,0) is the first position at the top left. In the HTML file, row and column numbers are also displayed to help identify positions.  

## How to install the project?

    composer install
    npm install
    cp .env.example .env
    
    // Accept the creation of the database.sqlite
    php artisan migration --seed
    php artisan key:gen
    
    // Compile and build the assets
    npm run build
    
    // Start the service
    php artisan serve
    
    // Run tests if needed
    php artisan test

## How to use it?

Go to http://localhost:8000, and the interface will appear, allowing you to interact with the rovers. When selecting a rover, its position and orientation (NESW) will be displayed.

You can send movement commands using L, R, and F if a rover is selected. For example: FRFFFLRFFFFLLF.

- F: Moves forward according to its orientation.
- L: Turns left, changing its orientation.
- R: Turns right, changing its orientation.

After sending a command, the rover's position will be updated, and a message will display the result and details of the command.
