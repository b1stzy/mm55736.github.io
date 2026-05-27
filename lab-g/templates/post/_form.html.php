<label>Subject</label>
<input type="text" name="subject" value="<?= htmlspecialchars($post->getSubject() ?? '') ?>">

<label>Body</label>
<textarea name="body"><?= htmlspecialchars($post->getBody() ?? '') ?></textarea>

<button type="submit">Save</button>
