# To the Fullest

'To the Fullest' is a web application designed to make everyday a little less ordinary, and is my entry into the April 2022 Timathon.

You can see it in action [here](https://shannonnorris.co.uk/).

## Theme Interpretation

The theme for this Code Jam is **make everyday a little less ordinary**.

My interpretation of this theme, which led to the creation of various features, was that there are two ways to make everyday a little ordinary...
1. Altering small things about your day, just enough to add a little sparkle to make that day special. For example, you might dress a little bit differently, or go somewhere else for lunch that you don't usually go.
2. Going big with it and striving for a lifestyle change, which would change every single day in the build up to changing your future.

## Approach & Features

The languages/technologies used in the development of this entry include:

![HTML5](https://img.shields.io/static/v1?label=&message=HTML5&color=e44d26&style=flat&logo=HTML5&logoColor=white)
![CSS3](https://img.shields.io/static/v1?label=&message=CSS3&color=2965f1&style=flat&logo=CSS3&logoColor=white)
![JavaScript](https://img.shields.io/static/v1?label=&message=JavaScript&color=f7df1e&style=flat&logo=JavaScript&logoColor=white)
![PHP](https://img.shields.io/static/v1?label=&message=PHP&color=8993be&style=flat&logo=PHP&logoColor=white) 
![MySQL](https://img.shields.io/static/v1?label=&message=MySQL&color=00618a&style=flat&logo=MySQL&logoColor=white) 

**Homepage**

![Homepage](https://i.imgur.com/IhLFi2C.gif)

The homepage captures the goals of 'To the Fullest', with an about section explaining the mantra of the website and the features that exist to assist its users.

**Dashboard**

![Dashboard](https://i.imgur.com/RGq2E6a.gif)

This is the landing area once users signup or login. It greets them to the website and displays a randomly selected inspirational quote in front of an also random but equally inspiring landscape.

**Style Generator**

![Style Generator](https://i.imgur.com/MaCFwul.gif)

The style generator is one of the most basic features of the application. Nevertheless, it has significant potential to make the day a little less ordinary by randomly selecting a style for the user to wear.

**Activity Randomiser**

![Activity Randomiser](https://i.imgur.com/AV9Qi40.gif)

With similar function to the style generator, the activity randomiser selects an activity randomly from an assortment of options.

**Vision Boards**

![Vision Boards](https://i.imgur.com/gVnXhu7.gif)

This feature is arguably one of the most complex in the application, and has potential to encourage people to change their daily habits and thus make everyday a little less ordinary.

Users can create multiple vision boards to express their personal goals visually as a method of staying inspired and motivated. This involves adding text and images which are displayed on a canvas.

Regarding these vision boards:
* They are saved everytime they are drawn, and are saved in the exact layout/styles that they were drawn in so that you can keep it in a format that you like
* They save to a database making them accessible on other devices
* I had never used HTML canvases before and I learned a lot by making this, making the feature a project highlight for me.

**Bucket List**

![Bucket List](https://i.imgur.com/7zFNgqe.gif)

Users are able to create a bucket list of experiences/achievements they wish to achieve within their lifetime. Not only can they amend this to their hearts content, but they can also feel rewarded for their progress as a result of the progress section on the right-hand side; this consists of a pie chart as well as encouraging words relating to their progress individually.

**Sharing Platform**

![Share with Others](https://i.imgur.com/2Cosopo.gif)

When attempting to do anything that requires a level of motivation, it is exponentially more difficult without the right support network.

The 'Share with Others!' area enables people to do just that; they can view posts by anyone in the community and like and comment on their contributions. In this way, the community can inspire and uplift one another.

**Points of Note**
* AJAX has been utilised heavily to ensure that the user never has to leave the pages in the user area for scripts to execute.  In particular, the user never needs to refresh the peer support page to see new posts/comments/likes, and the JS code will only alter the aspects that need to be changed (e.g. individual timestamps, comment sections or like buttons) rather than re-rendering the entire area.
* Validation and error handling were a big focus on ensuring the completed project is well-polished.
* Security was considered for every feature. Additional PHP code is in place to ensure that users have not changed JS code to be able to amend/remove the vision boards or bucket lists of others.

## Project Recreation

The project can be seen [here](https://shannonnorris.co.uk/).

If you'd like to set it up yourself, please follow these steps:
1. Download/launch XAMPP
2. Start the Apache and MySQL modules
3. Download the project from this repo and save it in the XAMPP/htdocs directory
4. On PHPMyAdmin, create a new database called 'timathon' and import the database file included in this repo: 'timathon.sql'
5. Navigate to localhost to view the website

If you experience any issues with the database or have a login for PHPMyAdmin, then ensure the details in the db.ini file are accurate.

## Credit

'To the Fullest' is a solo project developed by Shannon Norris (AKA ThatPajamaLlama)

A couple of libraries were utilised in the solution:
* [tata](https://github.com/xrr2016/tata) (toasts)
* [chart.js](https://www.chartjs.org/) (used for piechart on bucket lists page)

In addition to this, the quote text/authors shown on the dashboard page are from a [JSON file created by nasrulhazim](https://gist.github.com/nasrulhazim/54b659e43b1035215cd0ba1d4577ee80).
