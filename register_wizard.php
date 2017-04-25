<div id="wizard">
	<ul class="tabs">
		<li class="active"><a class="Register" href="#tab1"></a></li>
		<li><a class="Profile" href="#tab2"></a></li>
		<li><a class="Medical" href="#tab3"></a></li>
		<li><a class="Goal" href="#tab4"></a></li>
	</ul>

	<div class="tab-content">
		<!-- FIRST: register -->
		<div id="tab1" class="content active">

			<div>
				<p>Name:</p>
				<input type="text" name="post_name" placeholder="Enter Your Name" data-validation="required" data-validation-error-msg="Required field" required/>
			</div>
			<div>
				<p>Email:</p>
				<input type="email" name="post_email" placeholder="Enter Your Email" data-validation="email" data-validation-error-msg="Enter a valid email address" required/>
			</div>
			<div>
				<p>Password:</p>
				<input name="post_password" type="password" placeholder="Enter Your Password" data-validation="length" data-validation-length="min8" data-validation-error-msg="Your password must be at least 8 characters long" required/>
				<input name="repeat" type="password" placeholder="Confirm Your Password" data-validation="confirmation" data-validation-confirm="post_password" data-validation-error-msg="passwords don't match"/>
			</div>

		</div>


		<!-- SECOND: profile -->
		<div id="tab2" class="content">

			<div>
				<p>Gender:</p>
				<input class="radio" type="radio" name="post_gender" value="male" checked>Male
				<input class="radio" type="radio" name="post_gender" value="female">Female
			</div>
			<div>
				<p>Age:</p>
				<input type="number" name="post_age" placeholder="Enter Your Age" data-validation="number" data-validation-allowing="range[1;150]" data-validation-error-msg="Invalid input" required/>
			</div>
			<div>
				<p>Weight:</p>
				<input type="number" name="post_weight" placeholder="Enter Your Weight in kg" data-validation="number" data-validation-allowing="range[30;300]" data-validation-error-msg="Invalid input" required/>
			</div>
			<div>
				<p>Height:</p>
				<input type="number" name="post_height" placeholder="Enter Your Height in cm" data-validation="number" data-validation-allowing="range[50;250]" data-validation-error-msg="Invalid input" required/>
			</div>
			<div>
				<p>Body Fat percentage(optional):</p>
				<input type="number" step="0.01" placeholder="optional: body fat %" name="post_bf"/>
			</div>
			<div>
				<p>Activity level:</p>
				<select name="post_activity" required>
					<?php include 'register_activity.php'; ?>
				</select>
			</div>

		</div>


		<!-- THIRD: MEDICAL -->
		<div id="tab3" class="content">
			<div>
				<p>Medical Conditions:</p>
				<ul>
					<?php include 'register_medical.php'; ?>
				</ul>
			</div>
		</div>

		<!-- THIRD: GOALS -->
		<div id="tab4" class="content">
			<div>
				<p>Choose Goal:</p>
				<select name="post_goal" required>
					<?php include 'register_goal.php'; ?>
				</select>
			</div>
			<input type="submit" name="submit_register" value="Save & Submit"/>
		</div>

	</div>
	<!-- end of tab content  -->

	<ul class="pager" id="buttons">
		<li class="next"><a>next</a></li>
		<li class="previous"><a>previous</a></li>
	</ul>

</div>
