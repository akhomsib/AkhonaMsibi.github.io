<?php
session_start();
?>

<html>
	<head>
		<title>Contact - Akhona Msibi Portfolio</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="assets/css/main.css" />
		<noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
	</head>
	<body class="is-preload">

		<!-- Wrapper -->
			<div id="wrapper" class="fade-in">

				<!-- Header -->
				<header id="header">
					<a href="home.html" class="logo">Akhona Msibi</a>
				</header>

				<!-- Nav -->
					<nav id="nav">
						<ul class="links">
							<li><a href="home.html">Home</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="resume.html">Resume</a></li>
							<li><a href="projects.html">Projects</a></li>
							<li class="active"><a href="contact.php">Contact</a></li>
						</ul>
						<ul class="icons">
							<li><a href="http://www.linkedin.com/in/akhonamsibi" class="icon brands alt fa-linkedin"><span class="label">LinkedIn</span></a></li>
							<li><a href="https://github.com/akhomsib" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
						</ul>
					</nav>
				
				<!-- Main -->
					<div id="main">
						<form method="POST" id="contact-form" action="send_email.php">
							<div class="fields">
								<div class="field">
									<label for="name">Name</label>
									<input type="text" name="name" id="name" placeholder="Jane Doe" required/>
								</div>
								<div class="field">
									<label for="email">Email</label>
									<input type="email" name="email" id="email" placeholder="jane@doe.com" required/>
								</div>
								<div class="field">
									<label for="subject">Subject</label>
									<input type="text" name="subject" id="subject" placeholder="Hello!" required/>
								</div>
								<div class="field">
									<label for="message">Message</label>
									<textarea name="message" id="message" rows="6" placeholder="Enter message..." required></textarea>
								</div>
							</div>
							<ul class="actions">
								<li><input type="submit" value="Send Message" class="primary"/></li>
							</ul>
						</form>
						<script src="//cdnjs.cloudflare.com/ajax/libs/validate.js/0.13.1/validate.min.js"></script> 
						<script>
							const constraints = {
								name: {
								presence: { allowEmpty: false }
								},
								email: {
								presence: { allowEmpty: false },
								email: true
								},
                                subject: {
								presence: { allowEmpty: false }
								},
								message: {
								presence: { allowEmpty: false }
								}
							};
						
							const form = document.getElementById('contact-form');
							form.addEventListener('submit', function(event) {
								const formValues = {
								name: form.elements.name.value,
								email: form.elements.email.value,
                                subject: form.elements.subject.value,
								message: form.elements.message.value
								};
						
								const errors = validate(formValues, constraints);
								if (errors) {
								event.preventDefault();
								const errorMessage = Object.values(errors)
									.map(function(fieldValues) {
									return fieldValues.join(', ');
									})
									.join("\n");
						
								alert(errorMessage);
								}
							}, false);
							</script>
					</div>

				<!-- Footer -->
					<footer id="footer">
						<section class="split contact">
							<section class="alt">
								<h3>Location</h3>
								<p>Atlanta, GA<br />
								</p>
							</section>
							<section>
								<h3>Phone</h3>
								<p><a href="tel:+1352-284-8287">(352) 284-8287</a></p>
							</section>
							<section>
								<h3>Email</h3>
								<p><a href="mailto:akhomsib@gmail.com">akhomsib@gmail.com</a></p>
							</section>
							<section>
								<h3>Social</h3>
								<ul class="icons alt">
									<li><a href="http://www.linkedin.com/in/akhonamsibi" class="icon brands alt fa-linkedin"><span class="label">LinkedIn</span></a></li>
									<li><a href="https://github.com/akhomsib" class="icon brands alt fa-github"><span class="label">GitHub</span></a></li>
								</ul>
							</section>
						</section>
					</footer>
			</div>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/jquery.scrollex.min.js"></script>
			<script src="assets/js/jquery.scrolly.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>
			<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
			<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
			<script>
				var successMessage = 'Thank you for reaching out! I will be in touch.';
				var messageText = "<?= $_SESSION['status'] ?? ''; ?>";
				if (messageText != '') {
					if (messageText == successMessage) {
						Swal.fire({
							title: "Message sent!",
							text: messageText,
							icon: "success"
						});
						<?php unset($_SESSION['status']); ?>
					}
					else {
						Swal.fire({
							icon: "error",
							title: "Oops...",
							text: "Something went wrong! Please try again later."
						});
						<?php unset($_SESSION['status']); ?>
					}
				}
			</script>

	</body>
</html>