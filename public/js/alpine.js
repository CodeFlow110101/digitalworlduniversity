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
    checkScroll() {
      const container = this.$refs.scrollContainer;

      atTop =
        Math.ceil(Math.abs(container.scrollTop) + container.clientHeight) >=
        container.scrollHeight;

      if (atTop) {
        this.$wire
          .getPreviousChats(this.chats[this.chats.length - 1]["id"])
          .then(chats => {
            chats.forEach(chat => {
              this.chats.push(chat);
            });
          });
      }
    },
    uploadFile() {
      var formData = new FormData();
      var file = this.$refs.file.files[0];
      formData.append("file", file);

      $.ajax({
        url: "/upload-chat-file",
        type: "POST",
        headers: {
          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        data: formData,
        processData: false,
        contentType: false,
        success: response => {
          this.$wire.recieveUploadedFile(
            response["name"],
            response["url"],
            response["path"]
          );
        }
      });
    },
  };
}

function vimeoPlayer() {
  return {
    init() {
      const iframe = document.getElementById("vimeo-player");
      const player = new Vimeo.Player(iframe);
      player.on("ended", function() {
        Livewire.dispatch("video-completed");
      });
    }
  };
}

function copyToClipboard() {
  return {
    text: null,
    copied: false,
    copy() {
      navigator.clipboard.writeText(this.text);
      this.copied = true;
      setTimeout(() => (this.copied = false), 2000);
    }
  };
}

function darkMode() {
  return {
    value: true,
    init() {
      this.value = document.documentElement.classList.contains("dark");
    },
    toggle() {
      if (this.value) {
        document.documentElement.classList.add("dark");
      } else {
        document.documentElement.classList.remove("dark");
      }
    }
  };
}
