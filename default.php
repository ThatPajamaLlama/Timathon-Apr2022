<!DOCTYPE html>
<html>
    <?php include "assets/inc/head.php";?>
    <body id="default">
        <div class="container">
            <header>
                <h1 id="logo">To the fullest</h1>
                <nav class="navbar">
                    <ul>
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#features">Features</a></li>
                        <li class="action-button"><a href="#startnow">Start Now</a></li>
                    </ul>
                </nav>
            </header>
            
            <section id="home">
                <h1>Live every single day</h1>
                <h1>to the <span>fullest</span></h1>
            </section>

            <section id="about">
                <h1>About</h1>
                <div class="flex-container">
                    <div>
                        <h2>Our Mantra</h2>
                        <p>Often, life feels a little bit repetitive. It's inevitible, right? Wrong. That feeling of boredom in our everyday lives as we get stuck in a rhythm can be fought against.</p>
                        <p>Here, at <span class="site-name">To the fullest</span>, we believe in living everyday to the maximum, and that it shouldn't (and doesn't!) require a significant amount of effort to achieve this. We believe in making our everyday lives a little less ordinary in any way that we can, so that every day is an adventure.</p>
                        <p>That's exactly what this website is for - to provide you with ways to live everyday <span class="site-name">to the fullest</span>.</p>
                    </div>
                    <div>
                        <h2>What We Provide</h2>
                        <p>We can help you to make everyday a little less ordinary by providing ideas for the tiniest of tweaks; you don't have to do anything catastrophic in order to get out of your daily routine.</p>
                        <p>Although, if you're wanting to make a series of significant changes to your lifestyle, we can support you in making constructive changes to your everyday to enable you to work towards this goal.</p>
                        <p>You can learn more about how we do this by looking at <a href="#features">the features we offer</a>.</p>
                    </div>
                </div>
            </section>

            <section id="features">
                <h1>Features</h1>
                <p>We offer numerous features to make everyday less ordinary.</p>
                <p>Hover over one to learn more!</p>
                <div id="feature-board" class="flex-container">
                    <div>
                        <i class="fa fa-list" aria-hidden="true"></i>
                        <h2>Bucket List Creator</h2>
                        <p>Using our suggestions of activities, build a bucket list to plan those extra-extraordinary days.</p>
                    </div>
                    <div>
                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                        <h2>Vision Board Designer</h2>
                        <p>Using your own text and images, create vision boards to help you to change your future.</p>
                    </div>
                    <div>
                        <i class="fa fa-paint-brush" aria-hidden="true"></i>
                        <h2>Daily Style Generator</h2>
                        <p>Feel extraordinary by wearing a unique style.</p>
                    </div>
                    <div>
                        <i class="fa fa-list" aria-hidden="true"></i>
                        <h2>Daily Activity Generator</h2>
                        <p>Add an element of random to your day by generating an additional activity for today. It could be something as simple as buying something different for lunch.</p>
                    </div>
                    <div>
                        <i class="fa fa-comment" aria-hidden="true"></i>
                        <h2>Posting & Sharing</h2>
                        <p>Find divine inspiration from others and share what you're doing to make everyday less ordinary.</p>
                    </div>
                </div>
            </section>

            <section id="startnow">
                <h1>Start Now</h1>
                <p>In order to use our features, you'll need an account.</p>
                <form action="assets/proc/login_process.php" method="POST">
                    <div class="flex-container">
                        <div id="login" class="active"><a onclick="ChangeTab('login');">Login</a></div>
                        <div id="signup"><a onclick="ChangeTab('signup');">Signup</a></div>
                    </div>
                    <input type="text" name="username" id="username" placeholder="Username"/>
                    <input type="password" name="password" id="password" placeholder="Password"/>
                    <input type="password" name="password-confirmation" id="password-confirmation" placeholder="Confirm Password"/>
                    <input type="submit" value="Go"/>
                </form>
            </section>

        </div>
    </body>
</html>

<script type="text/javascript">
    const form = document.querySelector('section#startnow form');
    const signupTab = document.getElementById('signup');
    const loginTab = document.getElementById('login');
    const passwordConfirmationInput = document.getElementById('password-confirmation');

    function ChangeTab(newTab) {
        if (newTab == "login") {
            form.action = "assets/proc/login_process.php";
            passwordConfirmationInput.style.display = 'none';
            signupTab.classList.remove('active');
            loginTab.classList.add('active');
        } else {
            form.action = "assets/proc/signup_process.php";
            passwordConfirmationInput.style.display = 'block';
            loginTab.classList.remove('active');
            signupTab.classList.add('active');
        }
    }
</script>