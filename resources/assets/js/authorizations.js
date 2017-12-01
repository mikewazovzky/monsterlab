const user = window.App.user;

module.exports =  {
    updateComment(comment) {
        return comment.user_id === user.id;
    },

    createComment() {
        return user.role === 'writer';
    },

    updateProfile(profileUser) {
        return profileUser.id == user.id;
    }
};
