<!-- Login Section -->
<section class="form-section login-section">
    <div>
        <h4>LOGIN</h4>
        <p>Don't have an account yet? <a href="?action=signup">Sign up here!</a></p>
        
        <?php 
        $success_message = Session::get('success_message');
        if ($success_message): 
            Session::remove('success_message');
        ?>
            <div class="success-container">
                <div class="success"><?php echo htmlspecialchars($success_message); ?></div>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($errors)): ?>
            <div class="error-container">
                <?php foreach ($errors as $field => $error): ?>
                    <div class="error"><?php echo htmlspecialchars($error); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <form action="?action=handleLogin" method="post">
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
            
            <button type="submit" name="submit">LOGIN</button>
        </form>
    </div>
</section>