<!-- Signup Section -->
<section class="form-section signup-section">
    <div>
        <h4>SIGN UP</h4>
        <p>Already have an account? <a href="?action=login">Login here!</a></p>
        
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <?php foreach ($errors as $field => $error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="?action=handleSignup" method="post">
            <input type="hidden" name="<?php echo Config::CSRF_TOKEN_NAME; ?>" value="<?php echo htmlspecialchars($token); ?>">
            
            <div class="form-group">
                <input type="text" 
                       name="uid" 
                       placeholder="Username" 
                       value="<?php echo htmlspecialchars($old_input['uid'] ?? ''); ?>"
                       required
                       class="<?php echo isset($errors['uid']) ? 'error-input' : ''; ?>">
                <?php if (isset($errors['uid'])): ?>
                    <div class="field-error"><?php echo htmlspecialchars($errors['uid']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <input type="password" 
                       name="pwd" 
                       placeholder="Password" 
                       required
                       class="<?php echo isset($errors['pwd']) ? 'error-input' : ''; ?>">
                <?php if (isset($errors['pwd'])): ?>
                    <div class="field-error"><?php echo htmlspecialchars($errors['pwd']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <input type="password" 
                       name="pwdrepeat" 
                       placeholder="Repeat Password" 
                       required
                       class="<?php echo isset($errors['pwdrepeat']) ? 'error-input' : ''; ?>">
                <?php if (isset($errors['pwdrepeat'])): ?>
                    <div class="field-error"><?php echo htmlspecialchars($errors['pwdrepeat']); ?></div>
                <?php endif; ?>
            </div>
            
            <div class="form-group">
                <input type="email" 
                       name="email" 
                       placeholder="E-mail" 
                       value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>"
                       required
                       class="<?php echo isset($errors['email']) ? 'error-input' : ''; ?>">
                <?php if (isset($errors['email'])): ?>
                    <div class="field-error"><?php echo htmlspecialchars($errors['email']); ?></div>
                <?php endif; ?>
            </div>
            
            <button type="submit" name="submit">SIGN UP</button>
        </form>
    </div>
</section>