const user = window.App.user;

module.exports =  {
    updateReply(reply) {
        return reply.user_id === user.id;
    },

    createReply() {
        return user.role === 'writer';
    },

    updateProfile(profileUser) {
        return profileUser.id == user.id;
    }
};
