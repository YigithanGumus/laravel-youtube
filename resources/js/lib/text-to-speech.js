const textToSpeech = window.speechSynthesis;

export default function speechText(text) {
  let voiceList = textToSpeech.getVoices();
  const utterance = new SpeechSynthesisUtterance(text);

  // TR-tr dilindeki sesi seç
  for (const voice of voiceList) {
    if (voice.lang === "tr-TR") {
      utterance.voice = voice;
      break;
    }
  }

  utterance.pitch = 1;  // Sesin tonunu ayarlama
  utterance.rate = 1;   // Sesin hızını ayarlama
  textToSpeech.speak(utterance);
}
