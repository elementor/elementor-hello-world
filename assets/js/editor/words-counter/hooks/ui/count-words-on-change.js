import { CountWordsOnAttachPreview } from './count-words-on-attach-preview.js';

export class CountWordsOnChange extends CountWordsOnAttachPreview {
  getCommand() {
    return 'document/save/set-is-modified';
  }

  getId() {
    return 'count-words-on-change';
  }
}
