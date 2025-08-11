# 📚 Google Colab Notebook for CSV-Based EDA

# 🛠️ Step 1: Install Required Libraries
!pip install pandas matplotlib seaborn

# 🛠️ Step 2: Import Libraries
import pandas as pd
import seaborn as sns
import matplotlib.pyplot as plt

# 🛠️ Step 3: Load Data from CSV
# 🚨 Upload your CSV file when prompted
from google.colab import files

print("📂 Please upload your CSV file:")
uploaded = files.upload()

# Assuming the first file uploaded is the target file
csv_file = list(uploaded.keys())[0]

# Load the data into a pandas DataFrame
try:
    print("📡 Loading data from CSV...")
    df = pd.read_csv(csv_file)
    print("✅ Data loaded successfully!")
except Exception as e:
    print(f"❌ Error loading CSV: {e}")
    raise

# 🛠️ Step 4: EDA Functions
def perform_eda(data):
    # 1️⃣ Data Overview
    print("🔍 Data Overview:")
    print(data.info())
    print("\n🧹 Missing Values:\n", data.isnull().sum())
    print("\n🔢 Sample Data:\n", data.head())

    # 2️⃣ Statistical Summary
    print("\n📊 Statistical Summary:")
    print(data.describe())

    # 3️⃣ Visualizations
    print("\n📊 Generating Visualizations...")
    
    # Distribution of numerical columns
    numeric_cols = data.select_dtypes(include=['float64', 'int64']).columns
    for col in numeric_cols:
        plt.figure(figsize=(8, 5))
        sns.histplot(data[col].dropna(), kde=True, bins=30)
        plt.title(f"Distribution of {col}")
        plt.xlabel(col)
        plt.ylabel("Frequency")
        plt.show()

    # Correlation Heatmap
    if len(numeric_cols) > 1:
        plt.figure(figsize=(10, 8))
        sns.heatmap(data[numeric_cols].corr(), annot=True, cmap='coolwarm', fmt='.2f')
        plt.title("Correlation Heatmap")
        plt.show()

# 🛠️ Step 5: Run EDA
perform_eda(df)
