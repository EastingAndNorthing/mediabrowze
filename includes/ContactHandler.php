<?php

class ContactHandler {

  public $receiver = 'w.j.m.oosting@st.hanze.nl';
  public $confirm_subj = "Mediabrowze confirmation";
  public $confirm_msg = "Your message on Mediabrowze has been recieved.";

  public function sendMail($email, $subject, $message) {

    // Check if the user has filled out all required fields

    if(!empty($email) && !empty($subject) && !empty($message)) {

      // Use PHP's mail function to send an email. Returns a boolean, used to check if the mail was sent.

      if(mail($this->receiver, $subject, $message)) {

        // After sending the message, send a confirmation mail.

        if(mail($email, $this->confirm_subj, $this->confirm_msg)){

          return 'Message sent. You might have to check your spam box for the confirmation.';

        } else {
          return 'Something went wrong when sending your message.';
        }

      } else {
        return 'Something went wrong when sending your message.';
      }

    } else {
      return 'Please fill in all required fields.';
    }
  }

}
