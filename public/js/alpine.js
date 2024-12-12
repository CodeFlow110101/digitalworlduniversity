function chat() {
  return {
    chats: null,
    user: null,
    groupId: null,
    fileName: "",
    preview: "",
    init() {
      Echo.channel("group." + this.groupId).listen(".chat", e => {
        this.chats.unshift(e.message);
      });
    },
    destroy() {
      Echo.leaveChannel("group." + this.groupId);
    },
    handleFileSelect(event) {
      const file = event.target.files[0];

      if (file) {
        this.fileName = file.name;
        this.$wire.file = Math.floor(file.size / (1024 * 1024));
      } else {
        this.$wire.file = "";
        this.fileName = "";
      }
    },
    getTimestamp(timestamp) {
      let date = new Date(timestamp);
      formattedDate = new Intl.DateTimeFormat("en-US", {
        hour: "2-digit",
        minute: "2-digit",
        day: "2-digit",
        month: "short",
        year: "numeric"
      }).format(date);

      return formattedDate;
    },
  };
}
