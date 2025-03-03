import tkinter as tk
from tkinter import ttk, messagebox
import numpy as np
import sympy as sp

class App:
    def __init__(self, root):
        self.root = root
        self.root.title("Métodos Numéricos")
        self.root.geometry("800x500")
        
        # Sidebar
        self.sidebar = tk.Frame(self.root, bg="gray", width=150)
        self.sidebar.pack(side="left", fill="y")
        
        self.btn_euler = tk.Button(self.sidebar, text="Euler Mejorado", command=self.mostrar_euler)
        self.btn_runge_kutta = tk.Button(self.sidebar, text="Runge-Kutta", command=self.mostrar_runge_kutta)
        self.btn_newton = tk.Button(self.sidebar, text="Newton-Raphson", command=self.mostrar_newton)
        
        self.btn_euler.pack(pady=10, fill="x")
        self.btn_runge_kutta.pack(pady=10, fill="x")
        self.btn_newton.pack(pady=10, fill="x")
        
        # Frame principal
        self.main_frame = tk.Frame(self.root)
        self.main_frame.pack(side="right", expand=True, fill="both")
        
        # Campos y columnas para métodos ODE (Euler y Runge-Kutta)
        fields_ode = ["Valor inicial x", "Valor final x", "Tamaño de paso", "Valor inicial y", "Función f(x,y)"]
        columns_ode = ("Paso", "x", "y")
        # Para Newton-Raphson se usan: "Valor inicial x", "Máx Iteraciones", "Función f(x)" y "Derivada f(x)"
        fields_newton = ["Valor inicial x", "Máx Iteraciones", "Función f(x)", "Derivada f(x)"]
        columns_newton = ("Iteración", "x", "f(x)")
        
        # Crear las vistas con sus respectivos campos
        self.vista_euler = self.crear_vista("Método de Euler Mejorado", self.resolver_euler, fields_ode, columns_ode)
        self.vista_runge_kutta = self.crear_vista("Método de Runge-Kutta", self.resolver_runge_kutta, fields_ode, columns_ode)
        self.vista_newton = self.crear_vista("Método de Newton-Raphson", self.resolver_newton, fields_newton, columns_newton)
        
        self.mostrar_euler()
        
        # Footer
        self.footer = tk.Label(self.root, text="Realizado por Jorge Adrian Lira Lopez, 8C", bg="gray", fg="white")
        self.footer.pack(side="bottom", fill="x")
    
    def crear_vista(self, titulo, funcion_resolver, fields, columns):
        frame = tk.Frame(self.main_frame)
        
        # Título de la vista
        label = tk.Label(frame, text=titulo, font=("Arial", 14))
        label.pack(pady=10)
        
        # Crear diccionario local de entradas y asociarlo al frame
        entries = {}
        for campo in fields:
            lbl = tk.Label(frame, text=campo)
            lbl.pack()
            entry = tk.Entry(frame, width=30)
            entry.pack(pady=5)
            # Si es el campo "Derivada f(x)" se deshabilita para evitar edición
            if campo == "Derivada f(x)":
                entry.configure(state="disabled")
            entries[campo] = entry
        frame.entries = entries
        
        # Botón para resolver el problema
        btn_resolver = tk.Button(frame, text="Resolver Problema", command=lambda: funcion_resolver())
        btn_resolver.pack(pady=10)
        
        # Tabla para mostrar resultados, con columnas definidas
        tree = ttk.Treeview(frame, columns=columns, show="headings")
        for col in columns:
            tree.heading(col, text=col)
        tree.pack(expand=True, fill="both")
        frame.tree = tree
        
        return frame
    
    def mostrar_vista(self, vista):
        # Oculta todas las vistas y muestra la seleccionada
        for widget in self.main_frame.winfo_children():
            widget.pack_forget()
        vista.pack(expand=True, fill="both")
    
    def mostrar_euler(self):
        self.mostrar_vista(self.vista_euler)
    
    def mostrar_runge_kutta(self):
        self.mostrar_vista(self.vista_runge_kutta)
    
    def mostrar_newton(self):
        self.mostrar_vista(self.vista_newton)
    
    def resolver_euler(self):
        try:
            entries = self.vista_euler.entries
            tree = self.vista_euler.tree
            # Validar campos numéricos (excepto la función)
            for key in ["Valor inicial x", "Valor final x", "Tamaño de paso", "Valor inicial y"]:
                value = entries[key].get().strip()
                if value == "":
                    messagebox.showerror("Error", f"El campo '{key}' está vacío.")
                    return
                try:
                    float(value)
                except ValueError:
                    messagebox.showerror("Error", f"El campo '{key}' debe ser un número válido.")
                    return
            
            # Validar y ajustar la función (reemplazar ^ por **)
            f_expr = entries["Función f(x,y)"].get().strip()
            if f_expr == "":
                messagebox.showerror("Error", "El campo 'Función f(x,y)' está vacío.")
                return
            f_expr = f_expr.replace("^", "**")
            
            x0 = float(entries["Valor inicial x"].get().strip())
            xn = float(entries["Valor final x"].get().strip())
            h = float(entries["Tamaño de paso"].get().strip())
            y0 = float(entries["Valor inicial y"].get().strip())
            
            # Uso controlado de eval, pasando las variables y la librería np
            f = lambda x, y: eval(f_expr, {"x": x, "y": y, "np": np})
            
            tree.delete(*tree.get_children())
            x, y = x0, y0
            paso = 0
            while x <= xn:
                tree.insert("", "end", values=(paso, round(x, 6), round(y, 6)))
                y_pred = y + h * f(x, y)
                y = y + (h / 2) * (f(x, y) + f(x + h, y_pred))
                x += h
                paso += 1
        except Exception as e:
            messagebox.showerror("Error", f"Ocurrió un problema: {e}")
    
    def resolver_runge_kutta(self):
        try:
            entries = self.vista_runge_kutta.entries
            tree = self.vista_runge_kutta.tree
            # Validar campos numéricos
            for key in ["Valor inicial x", "Valor final x", "Tamaño de paso", "Valor inicial y"]:
                value = entries[key].get().strip()
                if value == "":
                    messagebox.showerror("Error", f"El campo '{key}' está vacío.")
                    return
                try:
                    float(value)
                except ValueError:
                    messagebox.showerror("Error", f"El campo '{key}' debe ser un número válido.")
                    return
            
            f_expr = entries["Función f(x,y)"].get().strip()
            if f_expr == "":
                messagebox.showerror("Error", "El campo 'Función f(x,y)' está vacío.")
                return
            f_expr = f_expr.replace("^", "**")
            
            x0 = float(entries["Valor inicial x"].get().strip())
            xn = float(entries["Valor final x"].get().strip())
            h = float(entries["Tamaño de paso"].get().strip())
            y0 = float(entries["Valor inicial y"].get().strip())
            
            f = lambda x, y: eval(f_expr, {"x": x, "y": y, "np": np})
            
            tree.delete(*tree.get_children())
            x, y = x0, y0
            paso = 0
            while x <= xn:
                tree.insert("", "end", values=(paso, round(x, 6), round(y, 6)))
                k1 = h * f(x, y)
                k2 = h * f(x + h/2, y + k1/2)
                k3 = h * f(x + h/2, y + k2/2)
                k4 = h * f(x + h, y + k3)
                y += (k1 + 2*k2 + 2*k3 + k4) / 6
                x += h
                paso += 1
        except Exception as e:
            messagebox.showerror("Error", f"Ocurrió un problema: {e}")
    
    def resolver_newton(self):
        try:
            entries = self.vista_newton.entries
            tree = self.vista_newton.tree
            # Validar campos para "Valor inicial x" y "Máx Iteraciones"
            for key in ["Valor inicial x", "Máx Iteraciones"]:
                value = entries[key].get().strip()
                if value == "":
                    messagebox.showerror("Error", f"El campo '{key}' está vacío.")
                    return
                try:
                    if key == "Máx Iteraciones":
                        int(value)
                    else:
                        float(value)
                except ValueError:
                    messagebox.showerror("Error", f"El campo '{key}' debe ser un número válido.")
                    return

            # Validar la función: se comprueba que no esté vacía y se ajusta la sintaxis
            f_expr = entries["Función f(x)"].get().strip()
            if f_expr == "":
                messagebox.showerror("Error", "El campo 'Función f(x)' está vacío.")
                return
            f_expr = f_expr.replace("^", "**")
        
            x0 = float(entries["Valor inicial x"].get().strip())
            max_iter = int(entries["Máx Iteraciones"].get().strip())
        
            # Definir la función y calcular la derivada simbólica con sympy
            x = sp.symbols('x')
            f_sym = sp.sympify(f_expr)
            df_sym = sp.diff(f_sym, x)
            # Formatear la derivada para mostrar "^" en lugar de "**" y eliminar asteriscos
            deriv_expr_str = str(df_sym).replace("**", "^").replace("*", "")
            
            # Actualizar el campo "Derivada f(x)" (solo lectura)
            deriv_entry = entries.get("Derivada f(x)")
            if deriv_entry is not None:
                deriv_entry.configure(state="normal")
                deriv_entry.delete(0, tk.END)
                deriv_entry.insert(0, deriv_expr_str)
                deriv_entry.configure(state="disabled")
        
            # Lambdify para evaluar f y df
            f_func = sp.lambdify(x, f_sym, "numpy")
            df_func = sp.lambdify(x, df_sym, "numpy")
            tol = 1e-6  # Tolerancia predeterminada
        
            tree.delete(*tree.get_children())
            x_val = x0
            iteracion = 0
            for _ in range(max_iter):
                fx = f_func(x_val)
                dfx = df_func(x_val)
                tree.insert("", "end", values=(iteracion, round(x_val, 6), round(fx, 6)))
                if abs(fx) < tol:
                    break
                if dfx == 0:
                    messagebox.showerror("Error", "Derivada cero, no se puede continuar.")
                    return
                x_val -= fx / dfx
                iteracion += 1
        except Exception as e:
            messagebox.showerror("Error", f"Ocurrió un problema: {e}")

root = tk.Tk()
app = App(root)
root.mainloop()
