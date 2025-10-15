# TODO: Add Like and Dislike Functionality to Publications

## 1. Create Migration for Publication Likes Table
- Create a new migration file for `publication_likes` table.
- Fields: user_id, publication_id, type (like/dislike), timestamps.
- Add unique constraint on user_id and publication_id to prevent duplicates.
- Add foreign key constraints.
- [x] COMPLETED: Migration created and run successfully.

## 2. Update Publication Model
- Add relationships: likes() and dislikes() using morphMany or hasMany with type filter.
- Add methods: getLikesCount(), getDislikesCount(), hasUserLiked(user_id), hasUserDisliked(user_id).
- [x] COMPLETED: Relationships and methods added.

## 3. Add Routes for Like/Dislike Actions
- Add POST routes for /publications/{publication}/like and /publications/{publication}/dislike.
- Ensure routes are protected by auth middleware.
- [x] COMPLETED: Routes added to web.php.

## 4. Update PublicationController
- Add like() and dislike() methods to handle AJAX requests.
- Validate user authentication.
- Check if user already liked/disliked, toggle or create new.
- Return JSON response with updated counts.
- [x] COMPLETED: Methods added with toggle functionality.

## 5. Update details.blade.php View
- Add like/dislike buttons with icons (thumbs up/down).
- Display current like and dislike counts.
- Implement AJAX calls on button clicks to update without page reload.
- Update button states based on user's current like/dislike status.
- Ensure buttons are only visible to authenticated users.
- [x] COMPLETED: Buttons added with JavaScript for AJAX functionality.

## 6. Run Migration and Test
- Execute `php artisan migrate` to create the new table.
- Test like/dislike functionality on publication details page.
- Verify counts update correctly and prevent duplicate actions.
- [x] COMPLETED: Migration run successfully. Ready for testing.
