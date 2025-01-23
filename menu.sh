#!/bin/bash

show_menu() {
    echo "Menu"
    echo "(1) Build containers "
    echo "(0) Please press to exit"
}

while true; do
    show_menu
    read -p "Enter your choice: " choice
    case $choice in
        0)
            echo "Exiting..."
            exit 0
            ;;
        1)
            echo "Building containers..."
            ./scripts/buildContainers.sh
            ;;         
        *)
            echo "Invalid choice, please try again."
            ;;
    esac
done
