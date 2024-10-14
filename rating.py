from transformers import AutoTokenizer, AutoModelForSequenceClassification
import torch

# Charger le modèle et le tokenizer
model_name = "nlptown/bert-base-multilingual-uncased-sentiment"
tokenizer = AutoTokenizer.from_pretrained(model_name)
model = AutoModelForSequenceClassification.from_pretrained(model_name)

def analyze_sentiment(comment):
    inputs = tokenizer(comment, return_tensors="pt", truncation=True, padding=True)
    outputs = model(**inputs)
    logits = outputs.logits
    predicted_class = torch.argmax(logits, dim=1).item() + 1  # Classes entre 1 et 5
    return predicted_class

# Exemple d'utilisation
if __name__ == "__main__":
    comment = "Très bon médecin !"
    score = analyze_sentiment(comment)
    print(f"Score du sentiment: {score}")
